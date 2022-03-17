export default class Hours {
    initialize() {
        this.loadHourData();
    }

    loadHourData(){
        let buttons = document.getElementsByName('editHour');
        if(buttons == null){
            return;
        }
        [].forEach.call(buttons, btn => {
            btn.addEventListener('click', async () => {
                let id = btn.id;
                let response = await this.requestHourPickedData(id);
                let data = response.data;
                let form = document.getElementById("formUpdateHour");
                form.setAttribute('action', 'horas/'+id+'');
                document.getElementById('day_edit').value = data.day_id;
                document.getElementById('from_edit').value = data.init_time;
                document.getElementById('to_edit').value = data.end_time;
            });
        });
    }

    async requestHourPickedData(id){
        let response = {
            'state': 500
        };
        await fetch("/horas/"+id+'/edit')
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

}
