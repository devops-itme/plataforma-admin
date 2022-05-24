export default class Boxes {
    boxes = [
        {
            number: 0,
            weight: 0,
            long: 0,
            broad: 0,
            high: 0,
            vol_weight: 0,
            description: '',
        }
    ];
    container = 'box-container';

    constructor(boxes = [], container = null) {
        if (boxes?.length != 0) {
            this.boxes = boxes;
        }
        if (container != null) {
            this.container = container;
        }
    }

    initialize() {
        this.instantiateBoxes();
        this.addBox();
        this.removeBox();
    }

    setInput() {
        const inputs = [
            'number[]',
            'weight[]',
            'long[]',
            'broad[]',
            'high[]',
            'vol_weight[]',
            'description[]',
        ];

        [].forEach.call(inputs, input => {
            let elements = document.getElementsByName(input);

            if (elements == null) {
                return
            }
            [].forEach.call(elements, el => {
                el.addEventListener('keyup', () => {

                    let parent = el.parentNode.parentNode.parentNode;
                    let children = el.parentNode.parentNode;

                    let index = Array.prototype.indexOf.call(parent.children, children);

                    let name = input.replace('[]', '');

                    this.boxes[index][name] = el.value;
                    // calculateRate(true, boxes, destination_rate_id);
                    // calculateRate(false, boxes, destination_rate_id);
                });
            });
        });
    }

    instantiateBoxes() {
        let boxContainer = document.getElementById(this.container);
        if (boxContainer == null) {
            return
        }
        boxContainer.innerHTML = ``;
        [].forEach.call(this.boxes, box => {
            let row = document.createElement("tr");
            row.className = `row border mt-0 text-center box-register col-md-13 "`;

            let numberCell = document.createElement("td");
            numberCell.className = `col-1 py-4 border-right`;
            numberCell.innerHTML = `<input type="number" name="id[]" class="form-control" min="0" value="${box.number}">`;
            row.appendChild(numberCell);

            let weightCell = document.createElement("td");
            weightCell.className = `col-1 py-4 border-right`;
            weightCell.innerHTML = `<input type="number" name="weight[]" class="form-control" min="0" value="${box.weight}">`;
            row.appendChild(weightCell);

            let longCell = document.createElement("td");
            longCell.className = `col-1 py-4 border-right`;
            longCell.innerHTML = `<input type="number" name="long[]" class="form-control" min="0" value="${box.long}">`;
            row.appendChild(longCell);

            let broadCell = document.createElement("td");
            broadCell.className = `col-1 py-4 border-right`;
            broadCell.innerHTML = `<input type="number" name="broad[]" class="form-control" min="0" value="${box.broad}">`;
            row.appendChild(broadCell);

            let highCell = document.createElement("td");
            highCell.className = `col-1 py-4 border-right`;
            highCell.innerHTML = `<input type="number" name="high[]" class="form-control" min="0" value="${box.high}">`;
            row.appendChild(highCell);

            let volWeightCell = document.createElement("td");
            volWeightCell.className = `col-1 py-4 border-right`;
            volWeightCell.innerHTML = `<input type="number" name="vol_weight[]" class="form-control" min="0" value="${box.vol_weight}">`;
            row.appendChild(volWeightCell);

            let descriptionCell = document.createElement("td");
            descriptionCell.className = `col-2 py-4 border-right`;
            descriptionCell.innerHTML = `<input type="text" name="description[]" class="form-control" placeholder="comentarios" value="${box.description}">`;
            row.appendChild(descriptionCell);

            let btnCell = document.createElement("td");
            btnCell.className = `col-1 py-4`;
            btnCell.innerHTML = ` <div class="d-flex flex-row flex-wrap justify-content-center"></div>`;

            let removeBoxBtn = document.createElement("a");
            removeBoxBtn.className = 'btn btn-icon btn-light-danger btn-sm mr-2 remove-box-btn';
            removeBoxBtn.id = `remove-box-btn`;
            removeBoxBtn.title = 'Borrar';
            removeBoxBtn.setAttribute('data-tooltip', '');
            removeBoxBtn.innerHTML = `<i class="fad fa-minus-circle"></i>`;

            btnCell.children[0].appendChild(removeBoxBtn);
            row.appendChild(btnCell);

            boxContainer.appendChild(row);
        });
        this.setInput();
        this.removeBox();
    };

    addBox(button = 'add-box-btn') {
        let addBoxBtn = document.getElementById(button);

        if (addBoxBtn == null) {
            return
        }

        addBoxBtn.addEventListener('click', () => {
            this.boxes.push({
                number: 0,
                weight: 0,
                long: 0,
                broad: 0,
                high: 0,
                vol_weight: 0,
                description: '',
            });
            this.instantiateBoxes();
            // calculateRate(true, boxes, destination_rate_id);
            // calculateRate(false, boxes, destination_rate_id);
        });
    }

    removeBox() {
        let boxes = this.boxes;
        let removeBoxBtn = document.getElementsByClassName("remove-box-btn");
        if (removeBoxBtn == null) {
            return;
        }

        [].forEach.call(removeBoxBtn, function (btn) {
            btn.addEventListener('click', () => {

                let box = btn.parentNode.parentNode.parentNode;
                let parent = box.parentNode;
                let index = Array.prototype.indexOf.call(parent.children, box);
                boxes.splice(index, 1);
                box.remove();
                // calculateRate(true, boxes, destination_rate_id);
                // calculateRate(false, boxes, destination_rate_id);
            });
        });
    }
}