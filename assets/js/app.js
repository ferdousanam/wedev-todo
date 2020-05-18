const vueApp = new Vue({
	el: '#app',
	data: {
		todos: [],
		filteredTodos: [],
		titleInput: '',
		activeNav: 'all',
		editId: null,
	},
	computed: {
		itemsLeftCount: function () {
			if (this.todos) {
				let itemsLeft = this.todos.filter((item) => {
					return parseInt(item.status) === 1
				})
				return itemsLeft.length
			} else {
				return 0;
			}
		}
	},
	mounted() {
		this.getAllTodos()
	},
	methods: {
		getAllTodos() {
			axios.get(`${apiRoot}/api/todo.php`).then(async (response) => {
				this.todos = response.data;
				this.filteredTodos = response.data;
				await this.onClickLoad(this.activeNav);
			});
		},
		addNewItem() {
			let formData = new FormData();
			formData.append('title', this.titleInput);
			if (this.titleInput) {
				axios.post(`${apiRoot}/api/todo.php`, formData).then(async (response) => {
					if (!response.data.error) {
						this.titleInput = '';
						await this.getAllTodos();
					}
				});
			}
		},
		onClickComplete(id) {
			let status = 1;
			let todo = this.todos.filter((item) => {
				return parseInt(item.id) === parseInt(id)
			})[0]
			if (parseInt(todo.status) === 1) {
				status = 2
			}
			let formData = new FormData();
			formData.append('method', 'PUT');
			formData.append('id', id);
			formData.append('status', status);
			axios.post(`${apiRoot}/api/todo.php`, formData).then(async (response) => {
				if (!response.data.error) {
					await this.getAllTodos();
				}
			});
		},
		onClickLoad(value) {
			this.activeNav = value;
			let status = null;

			if (value === 'active') {
				status = 1;
			} else if (value === 'completed') {
				status = 2;
			}
			if (status) {
				this.filteredTodos = this.todos.filter((item) => {
					return parseInt(item.status) === status
				})
			} else {
				this.filteredTodos = this.todos;
			}
		},
		editTitle(id) {
			this.editId = id;
			setTimeout(() => {
				document.getElementById('edit-title-' + this.editId).focus();
			}, 100)
		},
		updateTitle(e) {
			if (e.keyCode === 13) {
				let formData = new FormData();
				formData.append('method', 'PUT');
				formData.append('id', this.editId);
				formData.append('title', e.target.value);
				axios.post(`${apiRoot}/api/todo.php`, formData).then(async (response) => {
					if (!response.data.error) {
						this.editId = null;
						await this.getAllTodos();
					}
				});
			}
		},
		onClickRemoveCompleted() {
			let formData = new FormData();
			formData.append('clear_completed', true);
			axios.post(`${apiRoot}/api/todo.php`, formData).then(async (response) => {
				if (!response.data.error) {
					await this.getAllTodos();
				}
			});
		},
		showDelete(id) {
			let el = document.getElementById('close-button-' + id);
			if (el) {
				el.classList.remove("hide");
				el.classList.add("show");
			}
		},
		hideDelete(id) {
			let el = document.getElementById('close-button-' + id);
			if (el) {
				el.classList.remove("show");
				el.classList.add("hide");
			}
		},
		deleteTodo(id) {
			let formData = new FormData();
			formData.append('delete', true);
			formData.append('id', id);
			axios.post(`${apiRoot}/api/todo.php`, formData).then(async (response) => {
				if (!response.data.error) {
					await this.getAllTodos();
				}
			});
		}
	}
});
