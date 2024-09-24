<h2>Distance/Fare Calculator</h2>

<form method="GET">
    <div>
        From:
        <input type="text" name="from" value={{ request('from') }}>
        {{-- <select name="from">
            @foreach ($stations as $s)
                <option value={{ $s }} {{ request('from') == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select> --}}
    </div>
    <br>
    <div>
        To:
        <input type="text" name="to" value={{ request('to') }}>
        {{-- <select name="to">
            @foreach ($stations as $s)
                <option value={{ $s }} {{ request('to') == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select> --}}
    </div>
    <br>
    <button type="submit">Submit</button>
</form>

<hr>

<h3>Results:</h3>
<p>Distance is {{ $distance }}</p>
<p>Fare is {{ $fare }}</p>