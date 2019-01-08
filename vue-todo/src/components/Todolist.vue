<template>
    <div class="container">
        <h2>Todo List: </h2>
        <ul>
            <div v-if="todos.length === 0"> add Todo... </div>
            <li v-for="(todo, index) in todos">
                <div  
                    @click="completedTodo(todo.id)"
                    :class="{ 'changeChecked': todo.done }">
                    {{ todo.id }} -- {{ todo.done }} -- {{ todo.message }}
                </div>
                <button @click="deleteTodo(todo.id)">DeleteTodo</button>
            </li>
        </ul>
        <input 
            type="text"
            placeholder="add Todo..."
            v-model="newTodo"
            @keyup.enter="addTodo(newTodo)">
        
        <div>
            <div>
                
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    export default {
        data () {
            return {
                newTodo: ''
            }
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 data 上
                todos: 'getTodo',
            }),
             
        },
        methods: {
            ...mapActions([
                'addTodo', // map `this.addTodo(payload)` to `this.$store.dispatch('addTodo',payload)`
                'deleteTodo',
                'completedTodo',
            ]),
            // 其他 method call action 的方法
            callAction() {
                
            }
        },

    }
</script>

<style>
    .changeChecked {
        text-decoration: line-through;
        color: red;
    }
</style>

