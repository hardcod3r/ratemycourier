<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class CourierRatingPlayground extends Command
{
    protected $signature = 'courier:playground';
    protected $description = 'Playground for rating couriers via CLI';
    private $apiBase = 'http://localhost/api';
    private $token;

    public function handle()
    {
        $this->selectUser();
    }

    private function selectUser()
    {
        $users = $this->fetchUsers();

        if (empty($users)) {
            $this->error('Δεν υπάρχουν διαθέσιμοι χρήστες στη βάση δεδομένων.');
            return;
        }

        $userId = select(
            label: 'Επιλέξτε έναν χρήστη για σύνδεση',
            options: $users
        );


        spin(
            message: 'Γίνεται σύνδεση...',
            callback: function () use ($userId) {
                $user = User::find($userId);
                $response = Http::post("{$this->apiBase}/login", ['email' => $user->email, 'password' => 'password']);
                $this->token = $response->json('data.token');
            }
        );

        if (!$this->token) {
            $this->error("Αποτυχία σύνδεσης. Δοκιμάστε ξανά.");
            return $this->selectUser();
        }

        $this->info("Συνδεθήκατε επιτυχώς!");
        $this->listCouriers();
    }

    private function fetchUsers()
    {
        return User::pluck('name', 'id')->toArray();
    }

    private function listCouriers()
    {
        $couriers = $this->fetchCouriers();

        if (empty($couriers)) {
            $this->error('Δεν υπάρχουν διαθέσιμοι couriers.');
            return;
        }

        table(
            headers: ['ID', 'Τίτλος', 'Likes', 'Dislikes', 'Views', 'List Views', 'Details Views', 'Created At'],
            rows: $couriers
        );

        $courierId = select(
            label: 'Επιλέξτε ένα courier για προβολή λεπτομερειών',
            options: collect($couriers)->pluck(1, 0)->toArray()
        );

        $this->viewCourier($courierId);
    }

    private function fetchCouriers()
    {
        $response = Http::withToken($this->token)->get("{$this->apiBase}/couriers");
        return collect($response->json()['data'])->map(fn($c) => [
            $c['id'],
            $c['name'],
            $c['likes'],
            $c['dislikes'],
            $c['views'],
            $c['list_views'],
            $c['detail_views'],
            $c['created_at'],
        ])->toArray();
    }

    private function viewCourier($courierId)
    {
        $response = Http::withToken($this->token)->get("{$this->apiBase}/couriers/{$courierId}");
        $courier = $response->json()['data'];

        $this->info("Courier: {$courier['name']}");
        $this->info("Περιγραφή: {$courier['description']}");
        $this->info("Likes: {$courier['likes']} | Dislikes: {$courier['dislikes']} | Views: {$courier['views']} | List Views: {$courier['list_views']} | Details Views: {$courier['detail_views']}");
        $this->info("Δημιουργήθηκε στις: {$courier['created_at']}");

        $this->rateCourier($courierId);
    }

    private function rateCourier($courierId)
    {
        $choice = select(
            label: 'Βαθμολογήστε αυτό το courier',
            options: [
                '1' => 'Like',
                '2' => 'Dislike',
                '0' => 'Επιστροφή στη λίστα',
                '9' => 'Αποσύνδεση'
            ]
        );

        if ($choice == '0') {
            return $this->listCouriers();
        }

        if ($choice == '9') {
            $this->info("Αποσυνδεθήκατε επιτυχώς.");
            return;
        }

        spin(
            message: 'Υποβολή βαθμολογίας...',
            callback: function () use ($courierId, $choice) {
                Http::withToken($this->token)->post("{$this->apiBase}/rates", [
                    'courier_id' => $courierId,
                    'rate' => (int)$choice,
                ]);
            }
        );

        $this->info("Η βαθμολογία σας υποβλήθηκε!");
        $this->listCouriers();
    }
}
