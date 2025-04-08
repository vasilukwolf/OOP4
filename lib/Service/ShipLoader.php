<?php

namespace Service;

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;
use Model\ShipCollection;
use Model\BountyHunterShip;

class ShipLoader
{
    private $shipStorage;

    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

   /**
     * @return ShipCollection
     */
    public function getShips()
    {
        $ships = array();

        $shipsData = $this->queryForShips();

        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }
        $ships[] = new BountyHunterShip('Slave I');
        return new ShipCollection($ships);
    }

    /**
     * @param $id
     * @return AbstractShip
     */
    public function findOneById($id)
    {
        $shipArray = $this->shipStorage->fetchSingleShipData($id);

        return $this->createShipFromData($shipArray);
    }

    private function createShipFromData(array $shipData)
    {
        if ($shipData['team'] == 'rebel') {
            $ship = new RebelShip($shipData['name']);
        } else {
            $ship = new Ship($shipData['name']);
            $ship->setJediFactor($shipData['jedi_factor']);
        }

        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }

    private function queryForShips()
    {
        try {
            return $this->shipStorage->fetchAllShipsData();
        } catch (\Exception $e) {
            trigger_error('Exception! '.$e->getMessage());
            // if all else fails, just return an empty array
            return [];
        }
    }
}

