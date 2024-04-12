@extends('layout/tema')
@section('title', 'Clima')
@section('conteudo')
    <form action="{{url('buscaclima')}}">
        <select id="estado" name="estado">
            @foreach ($estados as $estado)
            <option value="{{$estado['sigla']}}">{{$estado['nome']}}</option>
            @endforeach
        </select>
        <span id="scidade"></span>
    </form>
    <div>
       Consulta do Clima<br>
    </div>
@endsection
