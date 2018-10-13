<template id="employee-edit">
<div>
    <h2>Редактирование</h2>
    <div v-if="success" class="alert alert-success">Сотрудник успешно изменен</div>
    <div v-if="allerrors">
        <ul v-for="(error, index) in allerrors" :key="index">
            <div v-for="(err, index) in error" :key="index" class="alert alert-danger">
                <li>{{ err }}</li>
            </div>                   
        </ul>
    </div>
    <form v-on:submit="saveForm()">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="edit-lastname" class="control-label">Фамилия</label>
                <input class="form-control"
                       id="edit-lastname" 
                       v-model="employee.lastname"/>                   
            </div>
            <div class="col-md-4 mb-3">
                <label for="edit-firstname" class="control-label">Имя</label>
                <input class="form-control" 
                       id="edit-firstname" 
                       v-model="employee.firstname"/>
            </div>
            <div class="col-md-4 mb-3">
                <label for="edit-middlename" class="control-label">Отчество</label>
                <input class="form-control" 
                       id="edit-middlename" 
                       v-model="employee.middlename"/>           
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="edit-position">Должность</label>
                <v-autocomplete :items="positions" 
                                v-model="position" 
                                :get-label="getPositionLabel"
                                :input-attrs="attrPosition" 
                                :auto-select-one-item='false'
                                :component-item='tplPosition'
                                @change="updatePositions"
                                @focus="updatePositions">                   
                </v-autocomplete>
            </div>
            <div class="col-md-4 mb-3">
                <label for="edit-parent">Начальник</label>
                <v-autocomplete :items="parents" 
                                v-model="parent"
                                :get-label="getParentLabel"
                                :input-attrs="attrParent"
                                :auto-select-one-item='false'
                                :component-item='tplParent'
                                @update-items="updateParents">                   
                </v-autocomplete>
            </div>
            <div class="col-md-2 mb-3">
                <label for="edit-salary">Зарплата</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number"
                           id="edit-salary"
                           v-model="employee.salary"
                           class="form-control"
                           aria-label="Зарплата:"
                           placeholder="Зарплата:"
                           lazy>
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>                              
            </div>
            <div class="col-md-2 mb-3">
                <label for="edit-employed">Принят</label>
                <datepicker :language="ru" 
                            :bootstrap-styling='true'
                            placeholder="Принят:"
                            :monday-first='true'
                            :clear-button='true'
                            v-model="employed_at"
                            clear-button-icon='fas fa-times'
                            id="edit-employed">
                    </datepicker>                
            </div>
        </div>
        <button class="btn btn-primary">Редактировать</button>
        <router-link class="btn btn-secondary" v-bind:to="'/list'">Отменить</router-link>
    </form>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import {en, ru} from 'vuejs-datepicker/dist/locale';
import moment from 'moment';
import ParentTemplate from '../autocomplete/ParentTemplate.vue';
import PositionTemplate from '../autocomplete/PositionTemplate.vue'

export default {
    data: function () {
            return {  
                    employeeId: null,
                    employee: { 
                        id: null,
                        lastname: '',
                        firstname: '',
                        middlename: '',
                        salary: null,
                        employed_at: null,
                        parent_id: null,
                        position: {
                            id: null                        
                        },
                        parent:{
                            id: null
                        }
                    },
                    allerrors: [],
                    success : false,
                    parent: {
                    },
                    parents: [],
                    position: {
                    },
                    positions: [],
                    uri: '/employees/',
                    attrPosition: {
                        class: 'form-control required',
                        id: 'add-position',
                        autocomplete: 'off',
                        name: 'input-position'
                    },
                    attrParent: {
                        class: 'form-control',
                        id: 'add-parent',
                        autocomplete: 'off',
                        name: 'input-parent'
                    },
                    employed_at: '',
                    en: en,
                    ru: ru,
                    tplParent: ParentTemplate,
                    tplPosition: PositionTemplate,
            }            
    },
    // created: function(){
    //     //let uri = this.uri + this.$route.params.id + '/edit';
    //     let uri = this.uri;
    //     axios.get(uri).then((response) => {
    //         this.employee = response.data;
    //     });
 
    // },
    // methods: {
    //     updateEmployee: function() {
    //         let uri = this.uri + this.$route.params.id;
    //         axios.patch(uri, this.employee).then((response) => {
    //             this.$router.push({name: 'Listemployees'}) 
    //         })
    //     }
    // }
    mounted() {
        this.fetchEmployee();         
    },
    watch:{
        employed_at(after, before){
            if (this.employed_at){
                this.employee.employed_at = moment(this.employed_at).format('YYYY-MM-DD');
            }
        }
    },
    methods: {
        fetchEmployee() {
            let id = this.$route.params.id;
            this.employeeId = id;
            axios.get('/employees/' + id)
                .then(({data}) => {
                    this.employee.id = data.data.id;
                    this.employee.lastname = data.data.lastname;
                    this.employee.firstname = data.data.firstname;
                    this.employee.middlename = data.data.middlename;
                    this.employee.salary = Number(data.data.salary);
                    this.employee.employed_at = data.data.employed_at;
                    this.employee.parent_id = data.data.parent_id;
                    this.parent = data.data.parent;
                    this.position = data.data.position;
                    // this.employee.position = data.data.position;
                    // this.employee.parent = data.data.parent;
                    this.employee.position.id = data.data.position.id;
                    this.employee.position.name = data.data.position.name;
                    this.employed_at = data.data.employed_at;
                })
                .catch(error => {
                    alert("Не удалось загрузить данные сотрудника");
                    //console.log(error.response);
                });
            },
        saveForm() {
            event.preventDefault();
            var app = this;
            if (app.position){
            app.employee.position_id = app.position.id;}
            if (app.parent){
            app.employee.parent_id = app.parent.id;}
            app.employee.employed_at = app.employed_at;
            axios.patch('/employees/' + app.employee.id, app.employee)
                 .then(({data}) => {
                    this.allerrors = [];
                    this.success = true;
                    //app.$router.replace('/list');
                })
                 .catch(error => {
                    //console.log(error.response);
                    this.allerrors = error.response.data.errors;
                    this.success = false;
                });
        },
        updateParents(text){
            this.getParents(text);
        },
        getParents(text){
            axios.get('/searchchiefs',
                 {params: {query: text}})
                .then(response => {
                    //this.parent.id = null;
                    //this.employee.parent.lastname = '';
                    this.parents = response.data.data;
                });
        },
        updatePositions(text){
            this.getPositions(text);
        },
        getPositions(text){
            axios.get('/positions',
                 {params: {query: text}})
                .then(response => {
                    //this.position_id = null;
                    //this.employee.position.name = '';
                    this.positions = response.data.data;
                });
        },
        getParentLabel (parent) {
            if (parent)
                return parent.lastname;
        },
        getPositionLabel (position) {
            if (position)
                return position.name;
        }
    },
    components: {
        Datepicker
    },
}
</script>
