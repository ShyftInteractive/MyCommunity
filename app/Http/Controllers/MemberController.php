<?php
namespace App\Http\Controllers;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Domain\DomainServices;
use App\Jobs\Roles\AddRoleToMember;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Domain\Members\MemberService;
use App\Jobs\Members\CreateNewMember;
use App\Domain\Members\MemberRepository;
use App\Exceptions\SelfRemovalException;
use App\Exceptions\AccountRemovalException;
use App\Domain\Members\Services\MemberUpdate;

class MemberController extends Controller
{
    protected  $viewLocation = '/Pages/MCS/Workspace/Members';

    public function __construct(protected MemberRepository $repository,
                                protected MemberService $memberService,
                                protected DomainServices $service) { }

    public function index(Request $request)
    {
        $members = $this->repository->searchableMembers(
            workspaceID: $request->get('workspace_id'),
            terms: $request->get('s'),
            fields: ['name', 'email'],
            orderBy: 'name',
            count: (int) $request->get('count')
        );

        return $this->getInertiaView(
            name: 'MemberIndex',
            props: [
                'members' => $members->toArray(),
            ]
        );

    }

    public function create(Request $request)
    {

        return $this->getInertiaView(name: 'MemberCreate');
    }

    public function edit(string $memberID, Request $request)
    {

        $member = $this->repository->getWorkspaceMemberByID(
            workspaceID: $request->get('workspace_id'),
            id: $memberID,
        );

        return inertia(Action::inertiaView($this, 'MemberEdit'), [
            'member' => $member,
            'memberRole' => $member->role($request->get('workspace_id')),
        ]);
    }

    public function update(string $memberID, Request $request)
    {
        $this->service->call(new MemberUpdate(
            memberID: $memberID,
            workspaceID: $request->get('workspace_id'),
            updates: $request->input(),
        ));

        return redirect()->route('member.index')->with('success', "Member Updated");
    }

    public function store(Request $request)
    {

        $member = $this->dispatch(new CreateNewMember(
            workspaceID: $request->get('workspace_id'),
            items: $request->input(),
        ));



        return redirect()->route('member.index')->with('success', "Member Created");
    }

    public function upload(string $memberID, AvatarRequest $request)
    {
        $this->memberService->uploadMemberAvatar(
            customerID: $request->get('customer_id'),
            workspaceID: $request->get('workspace_id'),
            memberID: $memberID,
            request: $request,
        );

        return json_encode(["success" => true]);
    }

    public function uploadDelete(string $memberID, Request $request)
    {
        $this->memberService->removeAvatar(
            workspaceID: $request->get('workspace_id'),
            memberID: $memberID,
        );

        return redirect()->back();
    }

    public function selected(string $action, Request $request)
    {
        $this->memberService->updateSelectedMembers(
            action: $action,
            workspaceID: $request->get('workspace_id'),
            requests: $request->input(),
        );

        return redirect()->back()->with(['success' => 'Updated!']);
    }

    public function destroy(string $memberID, Request $request)
    {
        try {
            $this->memberService->removeMemberFromWorkspace(
                workspaceID: $request->get('workspace_id'),
                activeUser: auth()->user()->id,
                memberID: $memberID,
            );
        } catch(SelfRemovalException|AccountRemovalException $e) {
            return redirect()->back()->with(['alert' => $e->getMessage()]);
        }

        return redirect()->back()->with(['success' => 'Member Removed']);
    }
}
