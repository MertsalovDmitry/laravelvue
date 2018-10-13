<template>
    <nav aria-label="Page pagination" role="navigation">
        <ul class="pagination pagination-top justify-content-center">
            <li class="page-item"
                :class="pagination.current_page <= 1 ? 'disabled' :''">
                <a class="page-link" 
                   @click.prevent="changePage(1)" 
                   href="#">
                    1
                </a>
            </li>

            <li class="page-item"
                :class="pagination.current_page <= 1 ? 'disabled' :''">
                <a class="page-link" 
                   @click.prevent="changePage(pagination.current_page - 1)" 
                   aria-label="Previous"
                   href="#">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <li class="page-item" 
                v-for="page in pages" 
                :key="page.id"
                :class="isCurrentPage(page) ? 'active' : ''" >
                <a class="page-link" 
                   @click.prevent="changePage(page)"
                   href="#">
                    {{ page }}
                </a>
            </li>

            <li class="page-item"
                :class="pagination.current_page >= pagination.last_page ? 'disabled' :''">
                <a class="page-link" 
                   @click.prevent="changePage(pagination.current_page + 1)" 
                   aria-label="Next"
                   href="#">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>

            <li class="page-item"
                :class="pagination.current_page >= pagination.last_page ? 'disabled' :''">
                <a class="page-link" 
                   @click.prevent="changePage(pagination.last_page)" 
                   href="#">
                    {{ pagination.last_page }}
                </a>
            </li>
        </ul>
    </nav>
</template>

<style>
    .pagination-top {
        margin-top: 30px;
    }
</style>

<script>
    export default {
        props: ['pagination', 'offset'],
        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },
        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }
</script>