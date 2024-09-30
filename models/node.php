<?php

class Map
{
    public $baslangic;
    public $bitis;
    public $kapaliHucres;
    public $stairs;
    public $elevators;
    public $floorCount;

    public function __construct($a, $b, $kapaliHucres = [], $stairs = [], $elevators = [], $floorCount = 1)
    {
        $this->baslangic = $a;
        $this->bitis = $b;
        $this->kapaliHucres = $kapaliHucres;
        $this->stairs = $stairs;
        $this->elevators = $elevators;
        $this->floorCount = $floorCount;
    }

    // Manhattan distance heuristic including floors
    private function heuristic($a, $b)
    {
        list($ax, $ay, $az) = explode("-", $a);
        list($bx, $by, $bz) = explode("-", $b);
        return abs($ax - $bx) + abs($ay - $by) + abs($az - $bz);  // Adding floor difference to the heuristic
    }

    // Get neighbors including floor transitions
    private function getNeighbors($x, $y, $z)
    {
        $neighbors = [
            [$x + 1, $y, $z],    // right
            [$x - 1, $y, $z],    // left
            [$x, $y + 1, $z],    // up
            [$x, $y - 1, $z],    // down
            [$x + 1, $y + 1, $z], // right-up diagonal
            [$x - 1, $y - 1, $z], // left-down diagonal
            [$x + 1, $y - 1, $z], // right-down diagonal
            [$x - 1, $y + 1, $z], // left-up diagonal
        ];

        // If at a staircase, add movement to the floor above or below
        foreach ($this->stairs as $stair) {
            if ("$x-$y" === $stair) {
                if ($z > 1) $neighbors[] = [$x, $y, $z - 1]; // Move to the floor below
                if ($z < $this->floorCount) $neighbors[] = [$x, $y, $z + 1]; // Move to the floor above
            }
        }

        // If at an elevator, add movement to any other floor
        foreach ($this->elevators as $elevator) {
            if ("$x-$y" === $elevator) {
                for ($newFloor = 1; $newFloor <= $this->floorCount; $newFloor++) {
                    if ($newFloor != $z) $neighbors[] = [$x, $y, $newFloor];  // Move to another floor
                }
            }
        }

        return $neighbors;
    }

    // Check if a cell is blocked
    private function isBlocked($x, $y, $z)
    {
        return in_array("$x-$y-$z", $this->kapaliHucres);
    }

    // Calculate the shortest path including floor levels
    public function calcutePathCordinates()
    {
        list($startX, $startY, $startZ) = explode("-", $this->baslangic);
        list($endX, $endY, $endZ) = explode("-", $this->bitis);

        $openList = [[$startX, $startY, $startZ]];
        $cameFrom = [];
        $gScore = ["$startX-$startY-$startZ" => 0];
        $fScore = ["$startX-$startY-$startZ" => $this->heuristic($this->baslangic, $this->bitis)];

        while (!empty($openList)) {
            // Sort by F-score
            usort($openList, function ($a, $b) use ($fScore) {
                return ($fScore["$a[0]-$a[1]-$a[2]"] ?? PHP_INT_MAX) <=> ($fScore["$b[0]-$b[1]-$b[2]"] ?? PHP_INT_MAX);
            });

            $current = array_shift($openList);  // Get the node with the lowest F score
            $currentKey = "$current[0]-$current[1]-$current[2]";

            if ($current == [$endX, $endY, $endZ]) {  // Goal reached
                $path = [];
                while (isset($cameFrom[$currentKey])) {
                    $path[] = $currentKey;
                    $current = $cameFrom[$currentKey];
                    $currentKey = "$current[0]-$current[1]-$current[2]";
                }
                $path[] = $this->baslangic;
                return array_reverse($path);
            }

            // Check neighbors
            foreach ($this->getNeighbors($current[0], $current[1], $current[2]) as $neighbor) {
                list($nx, $ny, $nz) = $neighbor;
                // Check if out of bounds or blocked
                if ($nx < 1 || $ny < 1 || $nz < 1 || $nx > 11 || $ny > 11 || $nz > $this->floorCount || $this->isBlocked($nx, $ny, $nz)) {
                    continue;
                }

                $neighborKey = "$nx-$ny-$nz";
                $tentativeGScore = ($gScore[$currentKey] ?? PHP_INT_MAX) + 1;

                if ($tentativeGScore < ($gScore[$neighborKey] ?? PHP_INT_MAX)) {
                    // Better path found
                    $cameFrom[$neighborKey] = $current;
                    $gScore[$neighborKey] = $tentativeGScore;
                    $fScore[$neighborKey] = $tentativeGScore + $this->heuristic("$nx-$ny-$nz", $this->bitis);
                    if (!in_array($neighbor, $openList)) {
                        $openList[] = $neighbor;
                    }
                }
            }
        }

        return ['Yol Yok'];  // No path found
    }
}
