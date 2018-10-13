<template>
    <i class="fas fa-sort"
        @click.prevent="sortPage()">
    </i>
</template>

<style>

</style>

<script>
    export default {
        data() {
            return {
                status: true
            }
        },
        props: ['sort','column'],
        methods: {
            sortPage() {
                this.status = !this.status;
                this.sort.direction = this.status ? 'asc' : 'desc'
                this.sort.column = this.column;
                this.$emit('sorting');
            }
        }
    }
</script>