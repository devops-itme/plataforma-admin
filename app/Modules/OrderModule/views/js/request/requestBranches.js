export const requestBranches = async () => {
    let response = {
        'state': 500
    };
    await fetch("/allBranches")
        .then(response => response.json())
        .then(data => {
            response = data
        })
        .catch(e => response.error = e);
    return response;
}