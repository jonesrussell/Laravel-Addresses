<?php

namespace Jonesrussell\Addresses;

use Illuminate\Support\ServiceProvider;

/**
 * Class AddressesServiceProvider
 * @package Jonesrussell\Addresses
 */
class AddressesServiceProvider extends ServiceProvider
{
    protected array $migrations = [
        'CreateAddressesTable' => 'create_addresses_table',
        'CreateContactsTable'  => 'create_contacts_table',

        'AddStreetExtraToAddressesTable' => 'add_street_extra_to_addresses_table',
        'AddGenderToContactsTable'       => 'add_gender_to_contacts_table',
        'AddTitleToContactsTable'        => 'add_title_to_contacts_table',

        'AddPropertiesToAddressesTable' => 'add_properties_to_addresses_table',
        'AddPropertiesToContactsTable'  => 'add_properties_to_contacts_table',

        'AddUserIdToAddressesTable'          => 'add_user_id_to_addresses_table',
        'AddUuidToAddressesAndContactsTable' => 'add_uuid_to_addresses_and_contacts_table',
        'AddVatIdToContactsTable'            => 'add_vat_id_to_contacts_table',
        'AddEmailInvoiceToContactsTable'     => 'add_email_invoice_to_contacts_table',

        'AddContactFieldsToAddressesTable' => 'add_contact_fields_to_addresses_table',
        'AddTitleFieldsToContactsTable'    => 'add_title_fields_to_contacts_table',
    ];

    public function boot()
    {
        $this->handleConfig();
        $this->handleMigrations();

        $this->loadTranslationsFrom(__DIR__ .'/../resources/lang', 'addresses');
    }

    /** @inheritdoc */
    public function register()
    {
        //
    }

    /** @inheritdoc */
    public function provides(): array
    {
        return [];
    }

    private function handleConfig(): void
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->publishes([$configPath => config_path('jonesrussell.php')]);

        $this->mergeConfigFrom($configPath, 'jonesrussell');
    }

    private function handleMigrations(): void
    {
        $count = 0;
        foreach ($this->migrations as $class => $file) {
            if (! class_exists($class)) {
                $timestamp = date('Y_m_d_Hi'. sprintf('%02d', $count), time());

                $this->publishes([
                    __DIR__ .'/../database/migrations/'. $file .'.php.stub' =>
                        database_path('migrations/'. $timestamp .'_'. $file .'.php')
                ], 'migrations');

                $count++;
            }
        }
    }
}
