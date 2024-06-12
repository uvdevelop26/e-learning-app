import {  isRef } from 'vue';

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

const deleteFile = (uploadedFiles, index) => {
    if (isRef(uploadedFiles)) {
        uploadedFiles.value.splice(index, 1);
    } else {
        console.warn("uploadedFiles is not reactive");
    }
}

const getFileData = (uploadedFiles, myFile) => {
    const file = myFile.files[0];
    if (isRef(uploadedFiles)) {
        uploadedFiles.value.push(file);
    } else {
        console.warn("uploadedFiles is not reactive");
    }

}

export { getFileType, imageUrl, deleteFile, getFileData }