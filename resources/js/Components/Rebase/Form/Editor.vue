<template>
   <div class="editor">
      <editor-menu-bubble :editor="editor" :keep-in-bounds="keepInBounds" @hide="hideLinkMenu" v-slot="{ commands, isActive, getMarkAttrs, menu }">
         <div class="menububble" :class="{ 'is-active': menu.isActive }" :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`">
            <button class="menububble__button" :class="{ 'is-active': isActive.bold() }" @click="commands.bold">
               <Icon name="bold" size="20" />
            </button>
            <button class="menububble__button" :class="{ 'is-active': isActive.heading({ level: 1 }) }" @click="commands.heading({ level: 1 })">H1</button>
            <button class="menububble__button" :class="{ 'is-active': isActive.heading({ level: 2 }) }" @click="commands.heading({ level: 2 })">H2</button>
            <button class="menububble__button" :class="{ 'is-active': isActive.heading({ level: 3 }) }" @click="commands.heading({ level: 3 })">H3</button>
            <button class="menububble__button" :class="{ 'is-active': isActive.italic() }" @click="commands.italic">
               <Icon name="italic" size="20" />
            </button>
            <button class="menububble__button" :class="{ 'is-active': isActive.underline() }" @click="commands.underline">
               <Icon name="underline" size="20" />
            </button>
            <button class="menububble__button" :class="{ 'is-active': isActive.strike() }" @click="commands.strike">
               <Icon name="strike" size="20" />
            </button>
            <button class="menububble__button" @click="showImagePrompt(commands.image)">
               <Icon name="image" size="20" />
            </button>
            <form class="menububble__form" v-if="linkMenuIsActive" @submit.prevent="setLinkUrl(commands.link, linkUrl)">
               <input class="menububble__input" type="text" v-model="linkUrl" placeholder="https://" ref="linkInput" @keydown.esc="hideLinkMenu" />
               <button class="menububble__button" @click="setLinkUrl(commands.link, null)" type="button">
                  <Icon name="remove" size="20" />
               </button>
            </form>
            <template v-else>
               <button class="menububble__button" @click="showLinkMenu(getMarkAttrs('link'))" :class="{ 'is-active': isActive.link() }">
                  <Icon name="link" size="20" />
               </button>
            </template>
         </div>
      </editor-menu-bubble>

      <editor-content class="editor__content" :editor="editor" @change="handleChange" />
   </div>
</template>

<script>
import Icon from "@/Components/Rebase/Icon"
import { Editor, EditorContent, EditorMenuBubble } from "tiptap"
import { Blockquote, BulletList, Heading, ListItem, OrderedList, Bold, Italic, Link, Strike, Underline, Image } from "tiptap-extensions"
import IFrame from "@/Data/MCS/IFrame.js"

export default {
   inheritAttrs: false,
   components: {
      EditorContent,
      EditorMenuBubble,
      Icon,
   },
   props: {
      content: String,
      value: [String],
   },
   data() {
      return {
         linkUrl: null,
         linkMenuIsActive: false,
         keepInBounds: true,
         editor: new Editor({
            extensions: [new Blockquote(), new BulletList(), new Heading({ levels: [1, 2, 3] }), new ListItem(), new OrderedList(), new Link(), new Bold(), new Italic(), new Strike(), new Underline(), new Image(), new IFrame()],
            content: this.value,
            onUpdate: ({ getHTML }) => {
               this.$emit("input", getHTML())
            },
         }),
      }
   },
   methods: {
      handleChange(e) {
         this.$emit("change", e.target.value)
      },
      showLinkMenu(attrs) {
         this.linkUrl = attrs.href
         this.linkMenuIsActive = true
         this.$nextTick(() => {
            this.$refs.linkInput.focus()
         })
      },
      hideLinkMenu() {
         this.linkUrl = null
         this.linkMenuIsActive = false
      },
      setLinkUrl(command, url) {
         command({ href: url })
         this.hideLinkMenu()
      },
      showImagePrompt(command) {
         const src = prompt("Enter the url of your image here")
         if (src !== null) {
            command({ src })
         }
      },
   },
   beforeDestroy() {
      this.editor.destroy()
   },
}
</script>
<style lang="scss">
.menububble {
   position: absolute;
   display: flex;
   z-index: 20;
   background: #000;
   border-radius: 5px;
   padding: 0.3rem;
   margin-bottom: 0.5rem;
   transform: translateX(-50%);
   visibility: hidden;
   opacity: 0;
   transition: opacity 0.2s, visibility 0.2s;

   &.is-active {
      opacity: 1;
      visibility: visible;
   }

   &__button {
      display: inline-flex;
      background: transparent;
      border: 0;
      color: #fff;
      padding: 0.2rem 0.5rem;
      margin-right: 0.2rem;
      border-radius: 3px;
      cursor: pointer;

      &:last-child {
         margin-right: 0;
      }

      &:hover {
         background-color: rgba(#fff, 0.1);
      }

      &.is-active {
         background-color: rgba(#fff, 0.2);
      }
   }

   &__form {
      display: flex;
      align-items: center;
   }

   &__input {
      font: inherit;
      border: none;
      background: transparent;
      color: #fff;
   }
}
</style>
