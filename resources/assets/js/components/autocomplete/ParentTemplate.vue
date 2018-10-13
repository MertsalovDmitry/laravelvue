<template>
  <div  class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">{{ item.lastname }} {{ item.firstname }} {{ item.middlename }}</p>
    </div>
    <span v-if="item.position" class="badge badge-primary badge-pill">{{ item.position.name }}</span>
  </div>
</template>

<script>
export default {
  props: {
    item: { required: false },
    searchText: { required: false }
  }
}
</script>