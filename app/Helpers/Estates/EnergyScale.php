<?php

namespace App\Helpers\Estates;

class EnergyScale
{
    protected $pfeilPosition;

    protected $picUrl;

    public function __construct($energyValue, $picUrl)
    {
        $this->setPfeilPosition($energyValue);
        $this->picUrl = $picUrl;
    }

    public function setPfeilPosition($energyValue)
    {
        // Definieren Sie die maximale Breite Ihrer Skala (in diesem Fall die Breite des SVG-Elements).
        $maxWidth = 270;

        // Berechnen Sie die Position des Pfeils basierend auf dem Energiebedarfswert.
        $this->pfeilPosition = ($energyValue / 250) * $maxWidth;

        // Berücksichtigen Sie den Offset von -50, sodass -50 als 0 behandelt wird.
        $this->pfeilPosition -= 73;

        // Begrenzen Sie die Position, um sicherzustellen, dass der Pfeil nicht außerhalb des SVG-Elements positioniert wird.
        $this->pfeilPosition = min($this->pfeilPosition, $maxWidth, 250); // Verhindert eine Positionierung rechts außerhalb des SVG-Elements.
    }

    public function getPfeilPosition()
    {
        return $this->pfeilPosition;
    }

    public function getPicUrl()
    {
        return $this->picUrl;
    }
}
