document.addEventListener("DOMContentLoaded", function () {
    const uploadForm = document.getElementById("uploadForm");
    const csvFileInput = document.getElementById("csvFile");
    const uploadButton = document.getElementById("uploadButton");
    const sqlOutput = document.getElementById("sqlOutput");

    uploadButton.addEventListener("click", function () {
        const formData = new FormData(uploadForm);

        fetch("convert.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((sql) => {
                sqlOutput.value = sql; // Display the SQL query in the textarea
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
});