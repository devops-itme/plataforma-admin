const notificaciones = [
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion " },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
    { id: 1, title: "Encabezado", description: "Descripcion de notificacion" },
];
export default class Notifications {
    initialize() {
        this.buildNotificationList(notificaciones);
    }
    buildNotificationList(params) {
        let notificationList = document.getElementById("notificationList");
        if (notificationList == null) {
            return;
        }

        let arraySlice = params.slice(0, 4);
        let cardContainer = document.createElement("div");
        cardContainer.classList = "card-body";
        let content = "";
        arraySlice.map((e) => {
            content += `

            <div class="notificacion1">
                        <h5 class="card-title">${e.title}</h5>
                        <p class="card-text">${e.description}</p>
                    <a href="/notificaciones" class="btn btn-primary d-block">Ver detalle</a>
                </div>
            <div class="separator separator-dashed separator-border-2 col-md-12 my-4"></div>

            `;
        });
        content += `
            <div class=" text-center text-uppercase py-0 cursor-pointer">
                <a href="/todasnotificaciones" class="text-dark col-md-12">Ver todo</a>
            </div>
        `;
        cardContainer.innerHTML = content;
        notificationList.appendChild(cardContainer);
    }
}
