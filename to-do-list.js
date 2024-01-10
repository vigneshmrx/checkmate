const inputTasksToScreen = (theContent, idOfColumn) => {
    console.log("inside input tasks function");
    console.log("COlumn id = " + idOfColumn);
    console.log("\n\nThe content = " + theContent);
    let columnId = document.getElementById(idOfColumn);

    // alert("inputTasksToScreen has been called with " + theContent);

    columnId.innerHTML += theContent + "<br>";
}