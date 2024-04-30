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
        id: 3,
        name: "Todas las Clases",
        href: "/clases",
        icon: "homework",
        role: ["alumno", "docente", "administrador"],
    },
    {
        id: 5,
        name: "Clases que Impartes",
        href: "..",
        submenu: [],
        role: ["docente"],
    },
    {
        id: 5,
        name: "Mis Clases",
        href: "..",
        submenu: [],
        role: ["alumno"],
    },
    {
        id: 2,
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
        id: 4,
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