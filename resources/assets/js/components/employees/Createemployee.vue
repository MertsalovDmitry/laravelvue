<template id="create-employee">
    <div>
        <h2>Добавить нового сотрудника</h2>
        <div v-if="success" class="alert alert-success">Сотрудник успешно добавлен</div>
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
                    <label for="add-lastname" class="control-label" required>Фамилия</label>
                    <input class="form-control"
                           id="add-lastname" 
                           v-model="employee.lastname"/>                   
                </div>
                <div class="col-md-4 mb-3">
                    <label for="add-firstname" class="control-label" required>Имя</label>
                    <input class="form-control" 
                           id="add-firstname" 
                           v-model="employee.firstname"/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="add-middlename" class="control-label" required>Отчество</label>
                    <input class="form-control" 
                           id="add-middlename" 
                           v-model="employee.middlename"/>           
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="add-position">Должность</label>
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
                    <label for="add-parent">Начальник</label>
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
                    <label for="add-salary">Зарплата</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number"
                               id="add-salary"
                               v-model="employee.salary"
                               class="form-control"
                               aria-label="Зарплата:"
                               placeholder="Зарплата:"
                               lazy
                               required>
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                                      
                </div>
                <div class="col-md-2 mb-3">
                    <label for="add-employed">Принят</label>
                    <datepicker :language="ru" 
                                :bootstrap-styling='true'
                                placeholder="Принят:"
                                :monday-first='true'
                                :clear-button='true'
                                v-model="employed_at"
                                clear-button-icon='fas fa-times'
                                id="add-employed">
                    </datepicker>                
                </div>
            </div>
            <button class="btn btn-primary">Создать</button>
            <router-link class="btn btn-secondary" :to="'/list'">Назад</router-link>
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
                    allerrors: [],
                    success : false,
                    parent: {},
                    parents: [],
                    position: {},
                    positions: [],
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
                    employee: {
                        // lastname: '',
                        // firstname: '',
                        // middlename: '',
                        // salary: '',
                        // employed_at: '',
                        position: {
                            id: null                        
                        },
                        parent:{
                            id: null
                        }
                    },
                    employed_at: '',
                    uri: '/employees',
                    en: en,
                    ru: ru,
                    tplParent: ParentTemplate,
                    tplPosition: PositionTemplate,
            }
    },
    watch:{
        employed_at(after, before){
            if (this.employed_at){
                this.employee.employed_at = moment(this.employed_at).format('YYYY-MM-DD');
            }
        }
    },
    methods: {
        saveForm() {
                event.preventDefault();
                var app = this;
                app.employee.position_id = app.position.id;
                app.employee.parent_id = app.parent.id;
                axios.post( app.uri, app.employee)
                .then(({data}) => {
                    this.allerrors = [];
                    this.success = true;
                    this.employee = {};
                    this.position= {};
                    this.parent = {};
                    this.employed_at = '';
                    //app.$router.push({path: '/'});
                })
                .catch(error => {
                    //alert("Не удалось создать сотрудника!");
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