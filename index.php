<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>To Do App</title>
	<link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div id="app" class="container">
	<div class="app-name"><h1>todos</h1></div>
	<div class="content">
		<div class="to-do-area">
			<form @submit.prevent="addNewItem">
				<input type="text" class="todo-input" name="" id="" placeholder="What needs to be done?" v-model="titleInput">
			</form>
			<div class="to-do-area-content">
				<div class="checkbox-container" v-for="(todo, index) in filteredTodos" :key="todo.id">
					<input class="completed-mark" type="checkbox" :checked="parseInt(todo.status) === 2">
					<span class="checkmark" @click="onClickComplete(todo.id)"></span>
					<div class="to-do-title" @mouseenter="showDelete(todo.id)" @mouseleave="hideDelete(todo.id)">
						<span v-if="editId !== todo.id" class="show" :class="{ 'text-completed': (parseInt(todo.status) === 2) }"
							  @dblclick="editTitle(todo.id)">{{ todo.title }}</span>
						<span v-if="editId !== todo.id" class="close-button hide" :id="'close-button-' + todo.id" @click="deleteTodo(todo.id)">x</span>
						<input v-if="editId === todo.id" type="text" @blur="editId = null" :value="todo.title" @keyup="updateTitle($event)"
							   :id="'edit-title-' + todo.id">
					</div>
				</div>
			</div>
			<div class="to-do-footer-area">
				<div>{{ itemsLeftCount }} items left</div>
				<div class="nav-pane">
					<span :class="{ active: activeNav === 'all' }" @click="onClickLoad('all')">All</span>
					<span :class="{ active: activeNav === 'active' }" @click="onClickLoad('active')">Active</span>
					<span :class="{ active: activeNav === 'completed' }" @click="onClickLoad('completed')">Completed</span>
				</div>
				<div style="text-align: right">
					<a @click.prevent="onClickRemoveCompleted">Clear Completed</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	window.apiRoot = 'http://localhost/todo'
</script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

<script type="text/babel" src="assets/js/app.js?v=<?= time() ?>"></script>
</body>
</html>
