const getFileType = (filename) => {
    if (filename.endsWith(".pdf")) {
        return "pdf";
    } else if (
        filename.endsWith(".jpeg") ||
        filename.endsWith(".jpg") ||
        filename.endsWith(".png") ||
        filename.endsWith(".gif")
    ) {
        return "picture";
    } else if (
        filename.endsWith(".doc") ||
        filename.endsWith(".docx") ||
        filename.endsWith(".xls") ||
        filename.endsWith(".xlsx") ||
        filename.endsWith(".ppt") ||
        filename.endsWith(".pptx")
    ) {
        return "office";
    }
};

const imageUrl = (url) => {
    return "/" + url.replace("public/", "storage/");
};

export { getFileType, imageUrl }