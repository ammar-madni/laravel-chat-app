<template>
  <div class="relative h-10 m-1">
    <div class="border-t-2 grid grid-cols-6">
      <input
        type="text"
        v-model="message"
        @keyup.enter="sendMessage()"
        placeholder="Say something..."
        class="col-span-5 p-1 border-none"
      />
      <button
        @click="sendMessage()"
        class="w-full place-self-end bg-gray-500 hover:bg-indigo-500 p-1 mt-1 rounded text-white col-span-1"
      >
        Send
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["topic"],
  data: function () {
    return {
      message: "",
    };
  },
  methods: {
    sendMessage() {
      if (this.message == " ") {
        return;
      }
      axios
        .post(`/chat/topic/${this.topic.id}/message`, {
          message: this.message,
        })
        .then((response) => {
          if (response.status == 201) {
            this.message = "";
            this.$emit("messagesent");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>