export const getDayReference = (day) => {
    let days = [
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
        "Domingo",
    ];
    day = new Date(day).getDay();
    return days[day];
}