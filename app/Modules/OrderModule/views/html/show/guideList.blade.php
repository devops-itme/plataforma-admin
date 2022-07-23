<div class="card-body pt-2">
    <h3 class="card-title col-10">
        Destino(s)
    </h3>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Dirección</th>
                <th scope="col">Contacto</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Correo</th>
                {{-- <th scope="col">Tarifa</th> --}}
                <th scope="col">
                    <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->getGuides as $guide)
                <tr>
                    <td>{{ $guide->id }}</td>
                    <td>{{ $guide->address_name }}</td>
                    <td>{{ $guide->contact }}</td>
                    <td>{{ $guide->phone_contact }}</td>
                    <td>{{ $guide->email_contact ?? 'No registra' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
