document.getElementById("createForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch("../php/create_playlist.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => {
      if (!res.ok) throw new Error("Failed to create playlist");
      return res.text();
    })
    .then(() => {
      alert("✅ Playlist created successfully!");
      this.reset(); // Clear the form
      loadPlaylists(); // Reload playlists dynamically
    })
    .catch((err) => alert("Error: " + err.message));
});

// Separate function to load playlists
function loadPlaylists() {
  fetch("../php/get_playlists.php")
    .then((res) => {
      if (!res.ok) throw new Error("Failed to fetch playlists");
      return res.json();
    })
    .then((data) => {
      const container = document.getElementById("playlists");
      if (data.length === 0) {
        container.innerHTML = "<p>No playlists found. Add one above.</p>";
        return;
      }
      container.innerHTML = data
        .map(
          (p) => `
        <div class="playlist-card" data-id="${p.id}">
          <h3>${p.name}</h3>
          <p>${p.description}</p>
          <a href="view_playlist.html?id=${p.id}">&#127925;View Songs</a>
          <button class="delete-btn" data-id="${p.id}">Delete</button>
        </div>`
        )
        .join("");

      // Add event listeners for delete buttons
      document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
          const playlistId = btn.getAttribute("data-id");
          if (
            confirm(
              "Are you sure you want to delete this playlist and all its songs?"
            )
          ) {
            fetch(`../php/delete_playlist.php?id=${playlistId}`, {
              method: "DELETE",
            })
              .then((res) => {
                if (!res.ok) throw new Error("Failed to delete playlist");
                alert("Playlist deleted!");
                loadPlaylists(); // refresh the list
              })
              .catch((err) => alert("Error: " + err.message));
          }
        });
      });
    })
    .catch((err) => {
      console.error("Error fetching playlists:", err);
      alert("Something went wrong while loading playlists.");
    });
}

// Load playlists on page load
loadPlaylists();
