const makeNewChecklist = () => {
    let ask = confirm("Would you like to start a new checklist for today?");
    if (ask) {
        fetch('/checklists/crud/create', {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.id) {window.location.href = `/checklists/single/${data.id}`;}
            else if (data.error) {alert(data.error);}
            else {alert("Failed to create a new checklist. Please try again.");}
        })
    }
}

document.addEventListener('checklist.new', makeNewChecklist);