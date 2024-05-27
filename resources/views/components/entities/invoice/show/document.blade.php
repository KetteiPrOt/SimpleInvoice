<div>
    @foreach($documentData as $name => $documentFact)
        <p>
            <strong>{{$translator[$name]}}</strong> <br>
            {{$documentFact}}
        </p>
    @endforeach

    <hr>

    <h2
        class="text-lg"
    >Detalles</h2>
    @foreach($documentDetails as $name => $detail)
        <div class="flex">
            @foreach($detail as $name => $value)
                <p class="mr-4">
                    <strong>{{$detailTranslator[$name]}}</strong> <br>
                    {{$value}}
                </p>
            @endforeach
        </div>
        <hr>
    @endforeach
</div>