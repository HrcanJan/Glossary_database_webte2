const form = document.getElementById("search-form");
const button = document.getElementById("search-button");
const tbody = document.getElementById("result-table").tBodies[0];
const gbody = document.getElementById("glosary-table").tBodies[0];

const userbutton = document.getElementById("userbutton");
const adminbutton = document.getElementById("adminbutton");

const user = document.getElementById("user");
const admin = document.getElementById("admin");

const language = document.getElementById("language");
const trans = document.getElementById("trans_lan");

let search = "translate.php?search=";
let check = false;

function changeCheck(){
    if (check)
        search = "translate.php?search=";
    else
        search = "translateD.php?search=";
    check = !check;
}

userbutton.addEventListener('click', () => {
    user.style.display = "block";
    userbutton.style.backgroundColor = "white";
    userbutton.style.color = "black";

    admin.style.display = "none";
    adminbutton.style.backgroundColor = "#1c1919";
    adminbutton.style.color = "white"
})

adminbutton.addEventListener('click', () => {
    admin.style.display = "block";
    adminbutton.style.backgroundColor = "white";
    adminbutton.style.color = "black";

    user.style.display = "none";
    userbutton.style.backgroundColor = "#1c1919";
    userbutton.style.color = "white"
})

button.addEventListener('click', () => {
    const data = new FormData(form);

    tbody.innerText = "";

    fetch(search+data.get('search')
        +"&language_code="+data.get('language_code'),
        {method: "get"})
        .then(response => response.json())
        .then(result => {
            result.forEach(item => {
                const tr = document.createElement("tr");
                const td1 = document.createElement("td");
                td1.append(item.searchTitle);
                const td2 = document.createElement("td");
                td2.append(item.translatedTitle);
                const td3 = document.createElement("td");
                td3.append(item.searchDescription);
                const td4 = document.createElement("td");
                td4.append(item.translatedDescription);

                if(trans.value === "trhere"){
                    td2.textContent = "-";
                    td2.style.textAlign = "center";
                    td4.textContent = "-";
                    td4.style.textAlign = "center";
                }

                if(language.value === "sk") {
                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tr.append(td4);
                }
                if(language.value === "en") {
                    tr.append(td2);
                    tr.append(td1);
                    tr.append(td4);
                    tr.append(td3);
                }
                tbody.append(tr);
            })
        })
})

fetch("glosary.php?search=", {method: "get"})
    .then(response => response.json())
    .then(result => {
        result.forEach(item => {
            const tr = document.createElement("tr");
            const td1 = document.createElement("td");
            td1.append(item.searchTitle);
            const td2 = document.createElement("td");
            td2.append(item.translatedTitle);
            const td3 = document.createElement("td");
            td3.append(item.searchDescription);
            const td4 = document.createElement("td");
            td4.append(item.translatedDescription);
            const td5 = document.createElement("td");
            const button = document.createElement("button");
            button.append("Vymaž");

            button.addEventListener("click", () => {
                fetch("delete.php", {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id: item.word_id})
                })
                    .then(response => response.json())
                    .then(result => {
                        if(result.deleted) {
                            tr.remove();
                        }
                    })
            });

            td5.append(button);
            tr.append(td1);
            tr.append(td2);
            tr.append(td3);
            tr.append(td4);
            tr.append(td5);
            gbody.append(tr);
        })
    })