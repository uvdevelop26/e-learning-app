import { reactive } from 'vue';

 const menu = reactive([
    {
        id: 1,
        name: "dashboard",
        href: "/dashboard",
        icon: "dashboard",
        role: ["alumno", "docente", "administrador"],
    },
    {
        id: 2,
        name: "Todas las Clases",
        href: "/clases",
        icon: "clases",
        role: ["alumno", "docente", "administrador"],
    },
    {
        id: 3,
        name: "Clases que Impartes",
        href: "..",
        submenu: [],
        role: ["docente"],
    },
    {
        id: 4,
        name: "Mis Clases",
        href: "..",
        submenu: [],
        role: ["alumno"],
    },
    {
        id: 5,
        name: "usuarios",
        href: "..",
        submenu: [
            { name: "alumnos", href: "/alumnos" },
            { name: "docentes", href: "/docentes" },
            { name: "administradores", href: "/administradores" },
        ],
        toggle_submenu: false,
        role: ["administrador"],
    },
    {
        id: 6,
        name: "académicos",
        href: "...",
        submenu: [
            { name: "carreras", href: "/carreras" },
            { name: "semestres", href: "/semestres" },
            { name: "materias", href: "/materias" },
        ],
        role: ["administrador"],
    },
]);

export default menu;