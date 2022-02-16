export default class BranchOffices {
    initialize() {
        this.loadPlanFields();
    }
    loadPlanFields(){
        let option = document.getElementById("branch_office_payment_method");
        let useMode = document.getElementById("useMode");
        let slcPlan = document.getElementById("slcPlan");
        if(option == null){
            return;
        }
        option.addEventListener('change', () => {
            if(option.value == 24){
                useMode.className = 'd-none';
                slcPlan.className = 'd-none';
            } else {
                useMode.className = 'form-group col-md-3';
                slcPlan.className = 'form-group col-md-3';
            }
        });
    }
}
