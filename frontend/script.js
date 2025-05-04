// frontend/script.js
document.addEventListener('DOMContentLoaded', () => {
    loadUsers();
    document.getElementById('userForm').addEventListener('submit', handleFormSubmit);
    document.getElementById('cancel').addEventListener('click', resetForm);
});

async function loadUsers() {
    const response = await fetch('http://localhost:8000/api/users');
    const users = await response.json();
    const tbody = document.getElementById('userTable');
    tbody.innerHTML = '';
    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.age}</td>
            <td>
                <button onclick="editUser(${user.id})">Edit</button>
                <button onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

async function handleFormSubmit(e) {
    e.preventDefault();
    const id = document.getElementById('userId').value;
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const age = document.getElementById('age');

    // Client-side validation
    let isValid = true;
    [name, email, age].forEach(input => input.classList.remove('error'));
    if (!name.value) {
        name.classList.add('error');
        isValid = false;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        email.classList.add('error');
        isValid = false;
    }
    if (!age.value || age.value < 1) {
        age.classList.add('error');
        isValid = false;
    }

    if (!isValid) return;

    const user = { name: name.value, email: email.value, age: parseInt(age.value) };
    const method = id ? 'PUT' : 'POST';
    const url = id ? `http://localhost:8000/api/users/${id}` : 'http://localhost:8000/api/users';

    await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user),
    });

    resetForm();
    loadUsers();
}

async function editUser(id) {
    const response = await fetch(`http://localhost:8000/api/users/${id}`);
    const user = await response.json();
    document.getElementById('userId').value = user.id;
    document.getElementById('name').value = user.name;
    document.getElementById('email').value = user.email;
    document.getElementById('age').value = user.age;
    document.getElementById('cancel').style.display = 'inline';
}

async function deleteUser(id) {
    await fetch(`http://localhost:8000/api/users/${id}`, { method: 'DELETE' });
    loadUsers();
}

function resetForm() {
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';
    document.getElementById('cancel').style.display = 'none';
    [document.getElementById('name'), document.getElementById('email'), document.getElementById('age')]
        .forEach(input => input.classList.remove('error'));
}