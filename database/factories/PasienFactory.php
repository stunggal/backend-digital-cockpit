<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
/**
 * Factory for creating `Pasien` (patient) model test data.
 *
 * Generates realistic patient records including contact details, status,
 * admission date and a random diagnosis. This is intended for seeding and
 * tests; adjust the ranges (e.g. `no_kamar`) to match your environment.
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // A list of example diagnoses used to populate the `diagnosa` field.
        // Keep this list focused and realistically relevant to your application.
        $diseases = [
            'Flu',
            'Covid-19',
            'Diabetes',
            'Hypertension',
            'Heart Attack',
            'Stroke',
            'Cancer',
            'Asthma',
            'Bronchitis',
            'Pneumonia',
            'Tuberculosis',
            'HIV/AIDS',
            'Hepatitis',
            'Malaria',
            'Dengue Fever',
            'Chikungunya',
            'Zika Virus',
            'Cholera',
            'Typhoid',
            'Dysentery',
            'Meningitis',
            'Rabies',
            'Tetanus',
            'Measles',
            'Mumps',
            'Rubella',
            'Chickenpox',
            'Diphtheria',
            'Whooping Cough',
            'Polio',
            'Yellow Fever',
            'Ebola',
            'SARS',
            'MERS',
            'Bird Flu',
            'Swine Flu',
            'Zoonotic Diseases',
            'Chronic Obstructive Pulmonary Disease',
            'Osteoarthritis',
            'Rheumatoid Arthritis',
            'Osteoporosis',
            'Gout',
            'Lupus',
            'Fibromyalgia',
            'Chronic Fatigue Syndrome',
            'Irritable Bowel Syndrome',
            'Crohn\'s Disease',
            'Ulcerative Colitis',
            'Celiac Disease',
            'Diverticulosis',
            'Gallstones',
            'Hemorrhoids',
            'Varicose Veins',
            'Cirrhosis',
            'Pancreatitis',
            'Gastritis',
            'Peptic Ulcers',
            'Gastroesophageal Reflux Disease',
            'Hernia',
            'Appendicitis',
            'Gallbladder Disease',
            'Kidney Stones',
            'Urinary Tract Infections',
            'Bladder Infections',
            'Prostate Disease',
            'Endometriosis',
            'Uterine Fibroids',
            'Ovarian Cysts',
            'Polycystic Ovary Syndrome',
            'Vaginitis',
            'Cervicitis',
            'Pelvic Inflammatory Disease',
            'Ectopic Pregnancy',
            'Infertility',
            'Menopause',
            'Pregnancy',
            'Childbirth',
        ];
        // Log to help diagnose seeding problems without printing to stdout
        Log::debug('PasienFactory generating a pasien record');

        return [
            // Full name (first + last)
            'nama' => $this->faker->firstName() . ' ' . $this->faker->lastName(),

            // Full address string
            'alamat' => $this->faker->address(),

            // Contact phone number
            'no_telp' => $this->faker->phoneNumber(),

            // National ID placeholder (credit card format used as fake number)
            'no_ktp' => $this->faker->creditCardNumber(),

            // Gender: 'L' = male, 'P' = female
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),

            // Date of birth
            'tanggal_lahir' => $this->faker->date(),

            // Patient status (string)
            'status' => $this->faker->randomElement(['Critical', 'Stable', 'Improving', 'Worsening']),

            // Avatar URL (placeholder image)
            'avatar' => 'https://picsum.photos/id/' . $this->faker->numberBetween(1, 1000) . '/640/640',

            // BPJS/insurance number placeholder
            'no_bpjs' => $this->faker->creditCardNumber(),

            // Occupation
            'pekerjaan' => $this->faker->jobTitle(),

            // Blood group
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),

            // Admission date (Y-m-d) within the last month
            'tgl_masuk' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),

            // Room number (adjust range to your hospital configuration)
            'no_kamar' => $this->faker->numberBetween(1, 100),

            // Primary diagnosis chosen from examples above
            'diagnosa' => $this->faker->randomElement($diseases),

            // Long-form description/notes
            'deskripsi' => $this->faker->realText(),
        ];
    }
}
