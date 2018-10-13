<template id="employee-delete">
    <div>
        <h2>Удалить сотрудника {{ employee.lastname }} {{ employee.firstname }} {{ employee.middlename }}</h2>
        <form v-on:submit.prevent="deleteEmployee">
            <p>Это действие нельзя будет отменить!</p>
            <button type="submit" class="btn btn-danger">Удалить</button>
            <router-link class="btn btn-secondary" :to="'/list'">Отменить</router-link>
        </form>
    </div>
</template>

<script>
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
                        id: null,
                        name: ''
                    }
                },
        }
    },
    mounted() {
        this.fetchEmployee();
    },
    methods: {
        deleteEmployee() {
                        let uri = '/employees/' + this.$route.params.id;
                        axios.delete(uri, this.employee).then((response) => {
                            this.$router.push({name: 'Listemployees'}) 
                         })
        },
        fetchEmployee() {
            let id = this.$route.params.id;
            this.employeeId = id;
            axios.get('/employees/' + id)
                .then(({data}) => {
                    this.employee.id = data.data.id;
                    this.employee.lastname = data.data.lastname;
                    this.employee.firstname = data.data.firstname;
                    this.employee.middlename = data.data.middlename;
                    this.employee.salary = data.data.salary;
                    this.employee.employed_at = data.data.employed_at;
                    this.employee.parent_id = data.data.parent_id;
                    this.employee.position.id = data.data.position.id;
                    this.employee.position.name = data.data.position.name;
                })
                .catch(error => {
                    //alert("Не удалось загрузить данные сотрудника");
                    //console.log(error.response);
                });
            },
    }
}
</script>