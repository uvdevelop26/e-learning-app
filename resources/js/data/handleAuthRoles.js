const getUserRoleArray = (pageProps, props) => {
    const userAuthRole = pageProps.userRole.role;

    switch (userAuthRole) {
        case 'administrador':
            return props.user.administradores || [];
        case 'docente':
            return props.user.docentes || [];
        case 'alumno':
            return props.user.alumnos || [];
        default:
            return [];
    }
};



export { getUserRoleArray }