<template>
  <app-layout>
    <template #header>
      <topic-selection
        v-if="currentTopic.id"
        :topics="topics"
        :currentTopic="currentTopic"
        v-on:topicchanged="setTopic($event)"
      />
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <message-container :messages="messages" />
          <input-message
            :topic="currentTopic"
            v-on:messagesent="getMessages()"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MessageContainer from "./MessageContainer.vue";
import InputMessage from "./InputMessage.vue";
import TopicSelection from "./TopicSelection.vue";

export default {
  components: {
    AppLayout,
    MessageContainer,
    InputMessage,
    TopicSelection,
  },
  data: function () {
    return {
      topics: [],
      currentTopic: [],
      messages: [],
    };
  },
  watch: {
    currentTopic(value, oldValue) {
      if (oldValue.id) {
        this.disconnect(oldValue);
      }
      this.connect();
    },
  },
  methods: {
    connect() {
      if (this.currentTopic.id) {
        let vm = this;
        this.getMessages();
        window.Echo.private(`chat.${this.currentTopic.id}`).listen(
          "NewChatMessage",
          (e) => {
            vm.getMessages();
          }
        );
      }
    },
    disconnect(topic) {
      window.Echo.leave(`chat.${topic.id}`);
    },
    getTopics() {
      axios
        .get("chat/topics")
        .then((response) => {
          this.topics = response.data;
          this.setTopic(response.data[0]);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    setTopic(topic) {
      this.currentTopic = topic;
    },
    getMessages() {
      axios
        .get(`/chat/topic/${this.currentTopic.id}/messages`)
        .then((response) => {
          this.messages = response.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {
    this.getTopics();
  },
};
</script>
