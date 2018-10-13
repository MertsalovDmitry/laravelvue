<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div v-if="employees.length"  class="card-body employee-tree-container">
                    <div class="row"> 
                        <div class="col-md-8">
                            <div class="card-header">Дерево сотрудников</div> 
                            <div class="card-body">
                                <div class="vue-tree">                            
                                    <ul>
                                        <tree-item class="item"
                                            v-for="employee in employees"
                                            :key="employee.id"
                                            :employee="employee"
                                            @update="onChildUpdate"
                                            :emp="emp"                                     
                                        ></tree-item>
                                    </ul>                   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 employee-info">
                            <div v-if="emp.lastname" class="card border-secondary" style="width: 18rem;">
                                <img v-if="emp.image" class="card-img-top" src="" alt="Фото сотрудника">
                                <div class="card-header text-primary">
                                    <h5 class="card-title">{{ emp.lastname }} {{ emp.firstname }} {{ emp.middlename }}</h5>
                                </div>
                                <ul class="list-group list-group-flush text-primary">
                                    <li v-if="emp.position" class="list-group-item">Должность: {{ emp.position.name }}</li>
                                    <li class="list-group-item">Зарплата: {{ emp.salary }}</li>
                                    <li class="list-group-item">Принят с: {{ emp.employed_at }}</li>
                                    <li v-if="emp.parent" class="list-group-item">Начальник: {{ emp.parent.lastname }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>                                    
                </div>
                <div v-else class="alert alert-warning" role="alert">
                    Не удалось загрузить дерево сотрудников
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
// https://ru.vuejs.org/v2/examples/tree-view.html
import TreeItem from './TreeItem.vue';
import Employee from '../../models/EmployeeTreeItem';
//import axios from '../../libs/axios';

export default {
    name: 'employees-tree',
    data() {
        return {
            employees: [],
            emp: {}
        }
    },
    methods: {
        read() {
            axios.get('/tree').then(({data}) => {
                Object.values(data.data).forEach(employee => {
                    this.employees.push(new Employee(employee));
                });
            });
        },
        onChildUpdate(emp){
            this.emp = emp;
        }
    },
    created() {
        this.read();
    },
    components: {
        TreeItem,
    }
}
</script>