<template>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    {{ item.name }}
    <span class="badge badge-primary badge-pill">#{{item.id}}</span>
  </li>
</template>

<script>
export default {
  props: {
    item: { required: false },
    searchText: { required: true }
  }
}
</script>