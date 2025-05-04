<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Management</title>
  <style>
    table, th, td {
      border: 1px solid #aaa;
      border-collapse: collapse;
      padding: 8px;
    }
    table {
      width: 100%;
      margin-top: 1rem;
    }
    input {
      margin-bottom: 0.5rem;
      padding: 6px;
    }
  </style>
</head>
<body>
  <h1>User Management</h1>

  <form id="userForm">
    <input type="hidden" id="userId" />
    <input type="text" id="name" placeholder="Name" required />
    <input type="email" id="email" placeholder="Email" required />
    <input type="number" id="age" placeholder="Age" required />
    <button type="submit">Save</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Age</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="userTableBody"></tbody>
  </table>

  <script>
    const apiUrl = "http://localhost:8000/users"; // ganti jika berbeda
    const userForm = document.getElementById("userForm");
    const userIdInput = document.getElementById("userId");
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const ageInput = document.getElementById("age");
    const tableBody = document.getElementById("userTableBody");

    // Fetch all users
    async function fetchUsers() {
      const res = await fetch(apiUrl);
      const users = await res.json();
      tableBody.innerHTML = "";
      users.forEach(user => {
        tableBody.innerHTML += `
          <tr>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.age}</td>
            <td>
              <button onclick='editUser(${JSON.stringify(user)})'>Edit</button>
              <button onclick='deleteUser("${user.id}")'>Delete</button>
            </td>
          </tr>
        `;
      });
    }

    // Create or update user
    userForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const userData = {
        name: nameInput.value,
        email: emailInput.value,
        age: ageInput.value
      };

      const userId = userIdInput.value;
      const method = userId ? "PUT" : "POST";
      const url = userId ? `${apiUrl}/${userId}` : apiUrl;

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(userData)
      });

      if (res.ok) {
        userForm.reset();
        userIdInput.value = "";
        fetchUsers();
      } else {
        alert("Terjadi kesalahan. Pastikan semua field benar.");
      }
    });

    // Edit user
    function editUser(user) {
      userIdInput.value = user.id;
      nameInput.value = user.name;
      emailInput.value = user.email;
      ageInput.value = user.age;
    }

    // Delete user
    async function deleteUser(id) {
      if (confirm("Hapus user ini?")) {
        const res = await fetch(`${apiUrl}/${id}`, { method: "DELETE" });
        if (res.ok) {
          fetchUsers();
        }
      }
    }

    fetchUsers();
  </script>
</body>
</html>
