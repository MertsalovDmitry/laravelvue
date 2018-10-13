<template id="employees-list">
    <div class="card card-default">
        <div class="card-header">
            <div class="form-row" >
                <div class="input-group col-sm-12 col-md-5 mb-3">
                    <input type="text" v-model.lazy="searchKey" 
                           class="form-control float-left"
                           id="search-element" 
                           placeholder="Поиск:"
                           aria-label="Поиск:"
                           lazy
                           requred
                           v-debounce="delay"/>
                </div>
                <div class="form-group check-parent col-sm-7 col-md-6 mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" 
                               class="custom-control-input" 
                               id="checkparent"
                               v-model.lazy="checked_parent"
                               v-debounce="delay">
                        <label class="custom-control-label" for="checkparent">Искать по начальнику</label>
                    </div>
                </div>
                <div class="col-sm-5 col-md-1 mb-3">
                    <router-link class="btn btn-primary float-right" 
                                 :to="{ name: 'create-employee' }">
                        <span class="fas fa-user-plus"></span>
                    </router-link>
                </div>
            </div>  
            <div class="form-row" >
                <div class="input-group col-sm-6 col-md-3 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number"
                           v-model.lazy="salaryFrom"
                           class="form-control" 
                           aria-label="Зарплата от:"
                           placeholder="Зарплата от:"
                           id="salary-from"
                           lazy
                           v-debounce="delay">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <div class="input-group col-sm-6 col-md-3 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number"
                           v-model.lazy="salaryTo"
                           class="form-control" 
                           aria-label="Зарплата до:"
                           placeholder="Зарплата до:"
                           id="salary-to"
                           lazy
                           v-debounce="delay">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-3">
                    <datepicker :language="ru" 
                                :bootstrap-styling='true'
                                placeholder="Принят c:"
                                input-class="text-center"
                                :monday-first='true'
                                :clear-button='true'
                                v-model.lazy="dateFrom"
                                clear-button-icon='fas fa-times'
                                @cleared="fetchNow()"
                                v-debounce="delay">
                    </datepicker>
                </div>
                <div class="col-sm-6 col-md-3 mb-3">
                    <datepicker :language="ru" 
                                :bootstrap-styling='true'
                                placeholder="Принят до:"
                                input-class="text-center"
                                :monday-first='true'
                                :clear-button='true'
                                v-model.lazy="dateTo"
                                clear-button-icon='fas fa-times'
                                @cleared="fetchNow()"
                                v-debounce="delay">
                    </datepicker>
                </div>

            </div>
        </div>
        <div v-if="employees.length"  class="card-body employee-table-container">
            <table class="table table-bordered table-striped employee-table">
                <thead class="thead-dark">
                    <tr>
                        <th>№ 
                            <sort  :sort="sort"
                                    :column="'id'"
                                    @sorting="fetchEmployees()"
                            ></sort>
                        </th>
                        <th>Фамилия 
                            <sort  :sort="sort"
                                    :column="'lastname'"
                                    @sorting="fetchEmployees()"
                            ></sort>
                        </th>
                        <th>Имя 
                            <sort  :sort="sort"
                                    :column="'firstname'"
                                    @sorting="fetchEmployees()"
                            ></sort></th>
                        <th>Отчество 
                            <sort  :sort="sort"
                                    :column="'middlename'"
                                    @sorting="fetchEmployees()"
                            ></sort>
                        </th>
                        <th>Должность
                            <sort  :sort="sort"
                                    :column="'position.name'"
                                    @sorting="fetchEmployees()"
                            ></sort>                       
                        </th>
                        <th>Зарплата 
                            <sort  :sort="sort"
                                    :column="'salary'"
                                    @sorting="fetchEmployees()"
                            ></sort>
                        </th>
                        <th>Принят 
                            <sort  :sort="sort"
                                    :column="'employed_at'"
                                    @sorting="fetchEmployees()"
                            ></sort>
                        </th>
                        <th>Начальник
                            <sort  :sort="sort"
                                    :column="'parent.lastname'"
                                    @sorting="fetchEmployees()"
                            ></sort>
                        </th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(employee, index) in employees" :key="employee.id">
                        <td>
                            {{ pagination.from + index}}
                        </td>
                        <td>
                            <div v-if="employee.lastname" v-html="$options.filters.highlight(employee.lastname, searchKey)">
                                {{ employee.lastname }}
                            </div>
                        </td>
                        <td>
                            <div v-if="employee.firstname" v-html="$options.filters.highlight(employee.firstname, searchKey)">
                                {{ employee.firstname }}
                            </div>
                        </td>
                        <td>
                            <div v-if="employee.middlename" v-html="$options.filters.highlight(employee.middlename, searchKey)"> 
                                {{ employee.middlename }}
                            </div>
                        </td>
                        <td>
                            <div v-if="employee.position" v-html="$options.filters.highlight(employee.position.name, searchKey)">
                                {{ employee.position.name }}
                            </div>
                        </td>
                        <td>
                            <div v-if="employee.salary" v-html="$options.filters.highlight(employee.salary, searchKey)"> 
                                {{ employee.salary }}
                            </div>
                        </td>
                        <td>
                            <div v-if="employee.employed_at">
                                {{ employee.employed_at }}
                            </div>
                        </td>
                        <td>
                            <div v-if="employee.parent" v-html="$options.filters.highlight(employee.parent.lastname, searchKey)">
                                {{ employee.parent.lastname }} 
                                {{ employee.parent.firstname | initial }}{{ employee.parent.middlename  | initial }}
                            </div>
                        </td>
                        <td>
                            <router-link class="btn btn-warning btn-sm"
                                         :to="{ name: 'edit-employee', params: {id: employee.id} }">
                                <i class="fas fa-user-edit"></i>
                            </router-link>
                            <router-link class="btn btn-danger btn-sm" 
                                         :to="{ name: 'delete-employee', params: {id: employee.id} }">
                                <i class="fas fa-user-times"></i>
                            </router-link>
                        </td>
                    </tr>
                    
                </tbody>
            </table>

            <pagination v-if="pagination.last_page > 1" 
                        :pagination="pagination" 
                        :offset="5" 
                        @paginate="fetchEmployees()">
            </pagination>
        </div>
        <div v-else class="alert alert-warning" role="alert">Совпадений не обнаружено </div>
    </div>
</template>

<script>
import Pagination from '../pagination/Pagination';
import Sort from '../sort/Sort';
import Datepicker from 'vuejs-datepicker';
import {en, ru} from 'vuejs-datepicker/dist/locale';
import moment from 'moment';
import debounce from 'v-debounce';

export default {
    data: function () {
            return {    
                employees: [], 
                sort: {
                    column: 'id',
                    direction: 'asc'
                },
                delay: 400,
                searchKey: null,
                salaryFrom: 0,
                salaryTo: 0,
                dateFrom: null,
                dateTo: null,
                checked_parent: false,
                pagination: {    
                    current_page: 1,
                    from: 1,
                    last_page: null,
                    path: null,
                    per_page: null,
                    to: null,
                    total: null,
                    first: null,
                    last: null,
                    prev: null,
                    next: null
                },
                en: en,
                ru: ru
            }
    },
    computed: {
        filteredEmployees: function () {
            if(this.employees.length){
                return this.employees.filter(function (employee) {
                    return this.searchKey=='' || employee.firstname.indexOf(this.searchKey) !== -1;
                    },this);
                }
        }
    },
    mounted() {
        this.fetchEmployees();
    },
    watch: {
        searchKey(after, before) {
            this.fetchNow();
        },
        salaryFrom(after, before){
            let salaryFrom = 0;
            let salaryTo = 0;
            if (this.salaryFrom){
                salaryFrom = Number.parseInt(this.salaryFrom, 10); 
            }
            if (this.salaryTo){
                salaryTo = Number.parseInt(this.salaryTo, 10); 
            }           
            if (salaryFrom < 0){
                this.salaryFrom = 0;
            }    
            this.fetchNow();
        },
        salaryTo(after, before){
            let salaryFrom = 0;
            let salaryTo = 0;
            if (this.salaryFrom){
                salaryFrom = Number.parseInt(this.salaryFrom, 10); 
            }
            if (this.salaryTo){
                salaryTo = Number.parseInt(this.salaryTo, 10); 
            }
            if (salaryTo < 0){
                this.salaryTo = 0;
            }
            this.fetchNow();
        },
        dateFrom(after, before){            
            if (this.dateFrom){
                this.dateFrom = moment(this.dateFrom).format('YYYY-MM-DD');
                this.fetchNow();
            }
        },
        dateTo(after, before){         
            if (this.dateTo){
                this.dateTo = moment(this.dateTo).format('YYYY-MM-DD');
                this.fetchNow();
            }
        },
        checked_parent(after, before){
            this.fetchNow();
        },
    },
    methods: {
        fetchEmployees() {
            let uri = '/employees';
            let search_par = '';
            if (this.searchKey){ search_par = '&search=' + this.searchKey; }
            if (this.checked_parent){ search_par += '&cpar=' + this.checked_parent; }
            if (this.salaryTo > 0){ search_par += '&searchst=' + this.salaryTo; } 
            if (this.salaryFrom > 0){ search_par += '&searchft=' + this.salaryFrom; }
            if (this.dateFrom){ search_par += '&df=' + this.dateFrom; }
            if (this.dateTo){ search_par += '&dt=' + this.dateTo; }
            axios.get(uri + 
                    '?page=' + this.pagination.current_page + 
                    '&c=' + this.sort.column + 
                    '&s=' + this.sort.direction +
                    search_par)
                .then(({data}) => {
                    this.employees = data.data;
                    this.pagination.current_page = data.meta.current_page,
                    this.pagination.from = data.meta.from,
                    this.pagination.last_page =  data.meta.last_page,
                    this.pagination.path = data.meta.path,
                    this.pagination.per_page = data.meta.per_page,
                    this.pagination.to = data.meta.to,
                    this.pagination.total = data.meta.total,
                    this.pagination.first =  data.links.first,
                    this.pagination.last =  data.links.last,
                    this.pagination.prev =  data.links.prev,
                    this.pagination.next =  data.links.next
                    // console.log('data');
                    // console.log(this.employees);
                    // console.log(data.data);
                }).catch(error => {
                    // console.log('error');
                    // console.log(error.data);
                    // console.log(error.response);                    
                });
        },
        fetchNow(){
            this.pagination.current_page = 1;
            this.fetchEmployees();
        },
    },
    filters: {
        // фильтр ицициалов
        initial: function (value) {
            if (!value) return ''
                value = value.toString()
                    return value.charAt(0).toUpperCase() + '.'
        },
        // фильтр для подсветки результатов поиска
        highlight: function(word, query){
            var check = new RegExp(query, "ig");
            return word.toString().replace(check, function(matchedText,a,b){
                return ('<span class="highlighted">' + matchedText + '</span>');
            })
        }
    },
    components: {
        Pagination,
        Sort,
        Datepicker
    },
    directives: {
        debounce
    },
}
</script>