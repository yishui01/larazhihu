<template>
  <a v-if="signedIn" class="text-secondary">
    <button
      type="submit"
      :class="voteUpClasses"
      @click="toggleVote"
      style="background-color: transparent;border-style: none"
    >
      <span></span>
      <span v-text="upVotesCount"></span>
    </button>

    <span> • </span>

    <button
      type="submit"
      :class="voteDownClasses"
      @click="toggleVoteDown"
      style="background-color: transparent; border-style: none"
    >
      <span></span>
      <span v-text="downVotesCount"></span>
    </button>
  </a>
</template>
<script>
    export default {
        props: ["answer"],

        data() {
            return {
                upVotesCount: this.answer.upVotesCount,
                downVotesCount: this.answer.downVotesCount,
                isVotedUp: this.answer.isVotedUp,
                isVotedDown: this.answer.isVotedDown,
            };
        },

        computed: {
            voteUpClasses() {
                return ["fa-thumbs-up", this.isVotedUp ? "fa" : "far"];
            },

            voteDownClasses() {
                return ["fa-thumbs-down", this.isVotedDown ? "fa" : "far"];
            },

            voteUpEndpoint() {
                return "/answers/" + this.answer.id + "/up-votes";
            },

            cancelVoteUpEndpoint() {
                return "/answers/" + this.answer.id + "/cancel-up-votes";
            },

            voteDownEndpoint() {
                return "/answers/" + this.answer.id + "/down-votes";
            },

            cancelVoteDownEndpoint() {
                return "/answers/" + this.answer.id + "/cancel-down-votes";
            },

            signedIn() {
                return window.App.signedIn;
            },
        },

        methods: {
            toggleVote() {
                if (this.isVotedUp) {
                    axios.post(this.cancelVoteUpEndpoint);

                    this.isVotedUp = false;
                    this.upVotesCount--;

                    flash("已取消赞同！");
                } else {
                    axios.post(this.voteUpEndpoint);

                    this.isVotedUp = true;
                    this.upVotesCount++;

                    flash("已赞同！");
                }
            },

            toggleVoteDown() {
                if (this.isVotedDown) {
                    axios.post(this.cancelVoteDownEndpoint);

                    this.isVotedDown = false;
                    this.downVotesCount--;

                    flash("已取消反对！");
                } else {
                    axios.post(this.voteDownEndpoint);

                    this.isVotedDown = true;
                    this.downVotesCount++;

                    flash("已反对！");
                }
            },
        },
    };
</script>
