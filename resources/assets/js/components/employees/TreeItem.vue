<template>   
    <li>
        <div>
            <i v-if="isParent"
                @click.stop="toggle"
               :class="{'far fa-plus-square': !isOpen, 'far fa-minus-square': isOpen}">
            </i>
            <span @click.stop="selectItem">
                <i v-if="isParent"
                   class="text-primary" 
                   :class="nodeClass()"></i>
                {{ employee.lastname }}
                {{ employee.firstname | initial }}
                {{ employee.middlename | initial }}
                <span class="badge badge-info">
                    {{ employee.children_count }}
                </span>
            </span>
                 
        </div>
        <ul v-show="isOpen">
            <i v-show="!isLoad" class="text-danger fa fa-spinner fa-pulse"></i>
            <tree-item
                class="item"
                v-for="(children) in employee.children"
                :employee="children"
                :key="children.id"
                @update="onChildUpdate"              
            ></tree-item>
        </ul>
    </li>
</template>
<script>
// https://ru.vuejs.org/v2/examples/tree-view.html

export default {
    name: 'tree-item',
    data() {
        return {
            isOpen: false,
            isLoad: false,
            //isSelect: false,
            icon: 'fas fa-toggle-off',
            openedIcon: 'fas fa-toggle-on',
            closedIcon: 'fas fa-toggle-off',
        }
    },
    props: [ 'employee', 'emp' ],
    computed: {
        isParent: function () {
            // return this.employee.children &&
            // this.employee.children.length;
            return !this.employee.isLeaf;
        },
    },
    methods: {
        toggle: function () {
            if (this.isParent) {               
                if (!this.isLoad){           
                    this.loadData(this.employee);                 
                }
                this.isOpen = !this.isOpen ;           
            }
            
        },
        loadData(employee){
            var id = employee.id;
            axios.get('/tree?id=' + id)
                .then(({data}) => {
                    employee.children = data.data;
                    this.isLoad = true;
                })
                .catch(error => {
                    alert("Не удалось");
                    //console.log(error.response);
                });
        },
        showIcon: function () {
                return this.icon || this.openedIcon || this.closedIcon;
        },
        nodeClass: function () {
            if (this.isOpen) {
                return this.openedIcon || this.icon;
            } else {
                return this.closedIcon || this.icon;
            }
        },
        onChildUpdate(emp){
            this.$emit('update', emp);
        },
        selectItem(){
            this.$emit('update', this.employee);
            //this.isSelect = !this.select;
        }

    }, 
    filters: {
        initial: function (value) {
            if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + '.'
        }
    },
    components: {
    
        }, 
}
</script>