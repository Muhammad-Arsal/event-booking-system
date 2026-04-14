<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class EventBookingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $reviewerUser = User::factory()->create([
            'name' => 'Hassan Raza',
            'email' => 'reviewer@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $guestUser = User::factory()->create([
            'name' => 'Ayesha Malik',
            'email' => 'ayesha@example.com',
            'password' => Hash::make('password123'),
        ]);

        $events = collect([
            $this->createEvent($adminUser->id, 'Laravel Community Summit', 'Karachi', now()->addDays(14)->setTime(18, 30), 120, 'A community-led evening on Laravel architecture, tooling, and practical scaling lessons.'),
            $this->createEvent($adminUser->id, 'Product Design Meetup', 'Lahore', now()->addDays(9)->setTime(19, 0), 60, 'A practical meetup focused on product discovery, user journeys, and design reviews.'),
            $this->createEvent($adminUser->id, 'Startup Pitch Night', 'Islamabad', now()->addDays(21)->setTime(17, 45), 80, 'Founders pitch their products to local mentors and early-stage operators.'),
            $this->createEvent($adminUser->id, 'Data Engineering Bootcamp', 'Karachi', now()->addDays(35)->setTime(10, 0), 45, 'Hands-on sessions around pipelines, warehousing, and reliable data workflows.'),
            $this->createEvent($adminUser->id, 'Women in Tech Circle', 'Lahore', now()->addDays(18)->setTime(16, 30), 50, 'Networking and speaker sessions with a focus on mentorship and career growth.'),
            $this->createEvent($adminUser->id, 'Freelancers Networking Evening', 'Karachi', now()->addDays(5)->setTime(20, 0), 70, 'An informal networking event for freelance developers, designers, and marketers.'),
            $this->createEvent($adminUser->id, 'E-commerce Growth Workshop', 'Faisalabad', now()->addDays(27)->setTime(15, 0), 40, 'A workshop on catalog strategy, checkout optimization, and retention campaigns.'),
            $this->createEvent($adminUser->id, 'DevOps for Teams Masterclass', 'Islamabad', now()->addDays(42)->setTime(11, 0), 55, 'Deployment workflows, monitoring basics, and team-friendly release practices.'),
            $this->createEvent($adminUser->id, 'AI Builders Weekend', 'Karachi', now()->addDays(60)->setTime(9, 30), 90, 'Two-day build sprint for practical AI product prototypes.'),
            $this->createEvent($adminUser->id, 'Annual Tech Expo 2026', 'Lahore', now()->addDays(120)->setTime(10, 30), 300, 'A large showcase of local startups, developer tools, and technical talks.'),
            $this->createEvent($adminUser->id, 'Mobile App Jam Session', 'Islamabad', now()->addDays(11)->setTime(18, 0), 35, 'Rapid mobile app ideation and prototype feedback circles.'),
            $this->createEvent($adminUser->id, 'Alumni Tech Talk 2025', 'Karachi', now()->subDays(40)->setTime(18, 30), 100, 'A retrospective alumni event featuring talks on growth and career transitions.'),
        ]);

        $laravelSummit = $events->firstWhere('title', 'Laravel Community Summit');
        $productMeetup = $events->firstWhere('title', 'Product Design Meetup');
        $pitchNight = $events->firstWhere('title', 'Startup Pitch Night');
        $networkingEvening = $events->firstWhere('title', 'Freelancers Networking Evening');
        $ecommerceWorkshop = $events->firstWhere('title', 'E-commerce Growth Workshop');
        $devopsMasterclass = $events->firstWhere('title', 'DevOps for Teams Masterclass');
        $aiWeekend = $events->firstWhere('title', 'AI Builders Weekend');
        $mobileJam = $events->firstWhere('title', 'Mobile App Jam Session');
        $alumniTalk = $events->firstWhere('title', 'Alumni Tech Talk 2025');

        // Reviewer account has both active and cancelled bookings for easy review.
        $this->bookSeats($reviewerUser, $laravelSummit, 2, 'booked', now()->subDays(8));
        $this->bookSeats($reviewerUser, $productMeetup, 1, 'booked', now()->subDays(5));
        $this->bookSeats($reviewerUser, $networkingEvening, 3, 'booked', now()->subDays(2));
        $this->bookSeats($reviewerUser, $aiWeekend, 2, 'cancelled', now()->subDays(6));
        $this->bookSeats($reviewerUser, $alumniTalk, 2, 'cancelled', now()->subDays(70));

        $this->bookSeats($adminUser, $pitchNight, 2, 'booked', now()->subDays(6));

        $this->bookSeats($guestUser, $laravelSummit, 20, 'booked', now()->subDays(7));
        $this->bookSeats($guestUser, $productMeetup, 54, 'booked', now()->subDays(4));
        $this->bookSeats($guestUser, $pitchNight, 18, 'booked', now()->subDays(3));
        $this->bookSeats($guestUser, $ecommerceWorkshop, 8, 'booked', now()->subDays(5));
        $this->bookSeats($guestUser, $devopsMasterclass, 5, 'booked', now()->subDays(4));
        $this->bookSeats($guestUser, $mobileJam, 35, 'booked', now()->subDays(2));
        $this->bookSeats($guestUser, $aiWeekend, 15, 'booked', now()->subDays(2));
    }

    private function createEvent(
        int $createdBy,
        string $title,
        string $location,
        Carbon $eventDateTime,
        int $totalSeats,
        string $description
    ): Event {
        return Event::factory()->create([
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'event_datetime' => $eventDateTime,
            'total_seats' => $totalSeats,
            'available_seats' => $totalSeats,
            'created_by' => $createdBy,
        ]);
    }

    private function bookSeats(User $user, Event $event, int $seats, string $status, Carbon $bookingDate): void
    {
        if ($status === 'booked') {
            $seats = min($seats, $event->available_seats);
        }

        if ($seats < 1) {
            return;
        }

        Booking::query()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'seats_booked' => $seats,
            'status' => $status,
            'booking_date' => $bookingDate,
        ]);

        if ($status === 'booked') {
            $event->decrement('available_seats', $seats);
            $event->refresh();
        }
    }
}
