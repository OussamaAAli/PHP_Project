const login = document.getElementById('Log_in');
const signup = document.getElementById('sign_up');

//login - sigup
signuppage = () => {
  login.style.display = 'none';
  signup.style.display = 'flex';
};
loginpage = () => {
  signup.style.display = 'none';
  login.style.display = 'flex';
};

//employee-user login
const btns = document.querySelectorAll('.btns');
const authsection = document.querySelectorAll('.authsection');

var slideNav = function (manual) {
  btns.forEach((btn) => {
    btn.classList.remove('active');
  });
  authsection.forEach((slide) => {
    slide.classList.remove('active');
  });

  btns[manual].classList.add('active');
  authsection[manual].classList.add('active');
};

btns.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    slideNav(i);
  });
});
document.getElementById("profileBtn").addEventListener("click", () => {
    fetch("get_user_info.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Afficher infos utilisateur
            document.getElementById("userName").innerText = "Nom : " + data.name;
            document.getElementById("userEmail").innerText = "Email : " + data.email;

            // Afficher les réservations
            const resList = document.getElementById("reservationList");
            resList.innerHTML = "";
            data.reservations.forEach((res) => {
                const li = document.createElement("li");
                li.innerText = `Type: ${res.RoomType}, Entrée: ${res.cin}, Sortie: ${res.cout}, Statut: ${res.stat}`;
                resList.appendChild(li);
            });

            // Afficher le conteneur
            document.getElementById("profileContainer").style.display = "block";
        })
        .catch((error) => {
            console.error("Erreur:", error);
        });
});
var bookbox = document.getElementById("guestdetailpanel");

openbookbox = () =>{
    bookbox.style.display = "flex";
}
closebox = () =>{
    bookbox.style.display = "none";
}

function toggleProfile() {
    var drawer = document.getElementById("profileDrawer");
    var content = document.getElementById("profileContent");

    if (drawer.style.width === "500px") {
        drawer.style.width = "0";
        content.innerHTML = ""; // Vider le contenu si on referme
    } else {
        drawer.style.width = "300px";

        // Charger le contenu depuis profil_content.php
        fetch("profil.php")
            .then(response => response.text())
            .then(data => {
                content.innerHTML = data;
            })
            .catch(error => {
                content.innerHTML = "<p>Erreur lors du chargement du profil.</p>";
                console.error(error);
            });
    }
}

