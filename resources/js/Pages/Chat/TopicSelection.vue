<template>
  <div class="flex justify-between items-center">
    <div>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ selected.topic }} Chat
      </h2>
    </div>
    <div>
      <select
        v-model="selected"
        @change="$emit('topicchanged', selected)"
        class="border-none"
      >
        <option v-for="(topic, index) in topics" :key="index" :value="topic">
          {{ topic.topic }}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  props: ["topics", "currentTopic"],
  data: function () {
    return {
      selected: "",
    };
  },
  created() {
    this.selected = this.currentTopic;
  },
};
</script>