<div class = "divCenter">
    <h2>АЛКОМЕТР 2000</h2>
    <div class="input-group">
        <table class="table">
            <thead>
                <tr>
                    <th>Ваш вес</th>
                    <th>Объем выпитого алкоголя (мл)</th>
                    <th>Градус</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input id="weight" type="text" class="form-control" value="60"></td>
                    <td><input id="volume" type="text" class="form-control" value="500"></td>
                    <td><input id="degree" type="text" class="form-control" value="5"></td>
                </tr>
            </tbody>
        </table>
        <button class="button" onclick="alcalc()">Посчитать</button>
    </div>
</div>
<script>
    function alcalc() {
        var magicConstant = 0.08125
        var weight = document.getElementById("weight").value
        var volume = document.getElementById("volume").value
        var degree = document.getElementById("degree").value
        var time = magicConstant * weight * volume / 100 * degree
        if (time > 60) {
            time = Math.floor(time / 60) + "ч. " + Math.round(time % 60)
        }
        alert("Алкоголь выветрится через " + time + "мин.")
    }
</script>