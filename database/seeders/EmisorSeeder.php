<?php

namespace Database\Seeders;

use App\Models\Emisor;
use Illuminate\Database\Seeder;

class EmisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //datos de prueba
        $emisor = new Emisor();
        $emisor->nombre = 'Empresa Prueba';
        $emisor->ruc = 20123456780;
        $emisor->telefono = "054-520403";
        $emisor->direccion = 'Calle Picaflores 100';
        $emisor->departamento = 'AREQUIPA';
        $emisor->provincia = 'AREQUIPA';
        $emisor->distrito = 'AREQUIPA';
        $emisor->ubigueo = '040101';
        $emisor->tokenapisperu = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDI2NDg0NTksImV4cCI6NDc5NjI0ODQ1OSwidXNlcm5hbWUiOiJhY2phZGVtIiwiY29tcGFueSI6IjIwMTIzNDU2NzgwIn0.XKJ1VzAgkr8m354nSO7vHulfaNY4qzbUWWQtzn0QP1qzNlboSdJjtC9Iv7DYNUvc_Q4Qkq6ss2lC9ayJIWtoaP1akFm0vty_vfAW6HBqrPl4ZMDD4UydhtxBQ1D7d61_BK5-cNN3dqUpBGgnF94fMnITg4EoxBi8SCPE8psQI7NawZdaMaL1-f4LZDpMUGZNhTjwAxbd7Wa0RQtyI-WiWt5iH9erOe8b7ok1xoIaVYrUeT9E_qfNRLQmiKuTIipAmo4LqxCPY7gGayo6jYvVwyszTT2cCtV5r_IPjgyC1L12QaKVrde0kgbWHQ4Sbq30vUSDLRapLDV-Cct53lmBWV05nFopH8NvhlWddr1G2l8VMRx4QdEVCP9V3KFbwkqh1nwTPtkBSa8R5TBM_k_8MKZFtlh2CiQWqjhe0aPcVjjnMBIdemuN-BBMRXkmIKpyh_DaCMJrClZcdjwSNYamKgklc6ObtwU6qXaGqlTjxZ7BbOvG3UbG8m3R2GXWOWtFkDr6lCSi5g81TKA7ekz03j_70QnuKL1h3dpBaCrC0y2SsHhpq7xK4gMwv-TjooqNRPLGIsu24jC83R_12ftq3-fuHb5Y8XMAqABKlV0BjBmJ5eZXdj3Cj_g4f6kXfno15l4wEh0KnmobfEK-7ejiWcmuSEy33WMgS8WqdiFyEM8';
        $emisor->save();

        // datos reales
        // $emisor = new Emisor();
        // $emisor->nombre = 'CORPORACION EDUCATIVA ESPARTA S.A.C.';
        // $emisor->ruc = 20605383905;
        // $emisor->telefono = "054-520403";
        // $emisor->direccion = 'CAL. SAN PEDRO NRO. 219 URB. CERCADO';
        // $emisor->departamento = 'AREQUIPA';
        // $emisor->provincia = 'AREQUIPA';
        // $emisor->distrito = 'AREQUIPA';
        // $emisor->ubigueo = '040101';
        // $emisor->tokenapisperu = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTE4MDg5NTEsImV4cCI6NDgwNTQwODk1MSwidXNlcm5hbWUiOiJhY2phZGVtIiwiY29tcGFueSI6IjIwNjA1MzgzOTA1In0.gsVQPej2fns19UReej5fNSmFZoEUzDR5yWWjIRXcicQe8xxnzxJmz9_6ZHTUPHGFWa_QfHE4fXK6DYd0GEjLFkRG3eGjGbNP0MCsGRwwH3gdckA0uScROjUD07qr54DBFBGQvZineVSb9BuQ2LefxsTCY3OJnJ1UQadESq9KVlQEkufkQXyqm0-_INkPT7k5S-Ha7l9cE4RlBJ_hbYsIrgFKFS13BL-rYO6nTGu9o5w7-1YZqHsVKhXyNDqai5Wypwv78s5jBnrLSGCoW0WJr7Z9xUtlOYlD8kgPYMFJhheT20kAK1hbiZ0BwBcRlIM8DLu3ffxLCpznkK-NaZoe3lyv7DMz0Reur8xEOlboah6fZllMZl0R3rhRLUUeqOiaRZYRZWrTEOdTxll3_RmMukkvYWvU-o1SvfHTL871ydcoOYAzeZytJ10VRXTcVkuUtbjt4fTTE3Iv9cXrjE4j3tC3JqwDb8lU2b7YI-0GaGz30t6FWS16hTpv7Uihu36_v3vfnQGhI5mEzR2rjzJPGKaZo0ebHMc3qLcU46wmFATCLNfkmzsiMtOEGECexxarUj6uuBSwvieFFtRDiwy6-bqOQ4rvZbwlbid3gExctAzUVD3t5uPoxrChvbl_lufs8LlLxbHYqV6NatvBBIgxC5keULJiKmHJiCMIxVNpyGk';
        // $emisor->save();
    }
}
