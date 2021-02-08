<?php
namespace App\Domain\Members;

trait MemberTransformers  {

    public function isVerified(string $memberID, string $emailToken): bool
    {
        return $this->id === $memberID && $this->email_token === $emailToken;
    }
}
