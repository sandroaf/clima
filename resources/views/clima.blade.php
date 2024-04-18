@extends('layout/tema')
@section('title', 'Clima')
@section('conteudo')
    <header>
        <h1>Consulta do Clima</h1>
    </header>
    <section>
        <form action="{{url('buscaclima')}}">
            <select id="estado" name="estado">
                <option value="00">Selecionar Estado</option>
                @foreach ($estados as $estado)
                <option value="{{$estado['sigla']}}">{{$estado['nome']}}</option>
                @endforeach
            </select>
            <span id="scidade"></span>
            <br><br>
            <button type="submit">Previsão</button>
        </form>
        <br>
        <div>{{$clima.}}</div>
    </section>
    <footer>
        Laravel - Clima
    </footer>
@endsection
