<?php

declare(strict_types=1);

namespace MyPlot\task;

use MyPlot\MyPlot;
use MyPlot\Plot;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\block\Grass;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class RoadFillTask extends Task
{

	private $plugin;
	private $level, $height, $bottomBlock, $plotFillBlock, $plotFloorBlock, $plotBeginPos, $xMax, $zMax, $maxBlocksPerTick;
	private $plot;
	private $plotSize;
	private $test2;
	private $test;
	private $pos;
	private $player;
	private $direction;
	private $grass;
	private $stonerand;
	private $plotWallBlock;
	/**
	 * @var int
	 */
	private $grose;
	/**
	 * @var int
	 */
	private $roadWidth;

	/**
	 * PlotMergeTask constructor.
	 *
	 * @param MyPlot $plugin
	 * @param int $maxBlocksPerTick
	 * @param Plot $plot
	 * @param Player $player
	 */
	public function __construct(MyPlot $plugin, Plot $plot, Player $player, $direction, int $maxBlocksPerTick = 256)
	{


		$this->plugin = $plugin;
		$this->player = $player;
		$this->direction = $direction;
		$this->plotBeginPos = $plugin->getPlotPosition($plot);
		$this->level = $this->plotBeginPos->getLevel();
		$plotLevel = $plugin->getLevelSettings($plot->levelName);
		$plotSize = $plotLevel->plotSize;
		$this->plotSize = $plotLevel->plotSize;
		$this->plotWallBlock = $plotLevel->wallBlock;
		$this->grose = $plotLevel->plotSize;
		$this->height = $plotLevel->groundHeight;
		$this->xMax = $this->plotBeginPos->x + 2 + $plotSize;
		$this->zMax = $this->plotBeginPos->z + 2 + $plotSize;
		$this->pos = new Vector3($this->plotBeginPos->x, 0, $this->plotBeginPos->z);
		$this->grass = $plotLevel->plotFloorBlock;
		$this->roadWidth = $plotLevel->roadWidth;
	}


	public function onRun(int $currentTick): void
	{
		$blocks = 0;
		switch($this->player->getDirection()){
			case 0:
				$direction = "east";
				break;
			case 1:
				$direction = "south";
				break;
			case 2:
				$direction = "west";

				break;
			case 3:
				$direction = "north";

				break;
			default:
				$this->player->sendMessage("§r§cOops, da ist etwas falsch gelaufen beim erkennen deiner Blickrichtung.");
				return;
				break;
		}

		$x = $this->player->getX();
		$y = $this->player->getY();
		$z = $this->player->getZ();
		$this->plugin->getServer()->getLogger()->notice("1");
		if($direction == "west") {
			for ($x = $this->plotBeginPos->x - $this->roadWidth; $x <= $this->xMax; $x++) {
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 1), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 2), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 3), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 4), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 5), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 6), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 7), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 8), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 9), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 10), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 11), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 12), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 13), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 14), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 15), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 16), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 17), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 18), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 19), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 20), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 21), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 22), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 23), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 24), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 25), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 26), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 27), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 28), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 29), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 30), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x -3, $this->height, $this->plotBeginPos->z + 31), $this->grass, false, false);
				$blocks++;
				if ($blocks >= 500) {
					$this->plugin->getScheduler()->scheduleDelayedTask($this, 1);
					return;
				}
			}
		}
		if($direction == "east") {
			for ($x = $this->plotBeginPos->x - $this->roadWidth + 5; $x <= $this->xMax; $x++) {
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 1), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 2), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 3), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 4), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 5), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 6), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 7), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 8), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 9), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 10), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 11), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 12), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 13), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 14), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 15), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 16), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 17), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 18), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 19), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 20), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 21), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 22), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 23), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 24), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 25), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 26), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 27), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 28), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 29), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 30), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x +4, $this->height, $this->plotBeginPos->z + 31), $this->grass, false, false);
				$blocks++;
				if ($blocks >= 500) {
					$this->plugin->getScheduler()->scheduleDelayedTask($this, 1);
					return;
				}
			}
		}

		if($direction == "south") {
			for ($x = $this->plotBeginPos->x - $this->roadWidth + 10; $x <= $this->xMax; $x++) {
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize + 1), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize + 2), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize + 3), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize + 4), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize + 5), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z + $this->plotSize + 6), $this->grass, false, false);
				$blocks++;
				if ($blocks >= 500) {
					$this->plugin->getScheduler()->scheduleDelayedTask($this, 1);
					return;
				}
			}
		}

		if($direction == "north") {
			for ($x = $this->plotBeginPos->x - $this->roadWidth + 10; $x <= $this->xMax; $x++) {
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 1 + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 2 + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 3 + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 4 + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 5 + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 6 + $this->plotSize), $this->grass, false, false);
				$this->level->setBlock(new Vector3($x - 3, $this->height, $this->plotBeginPos->z - $this->plotSize - 7 + $this->plotSize), $this->grass, false, false);
				$blocks++;
				if ($blocks >= 500) {
					$this->plugin->getScheduler()->scheduleDelayedTask($this, 1);
					return;
				}
			}

		}
		
	}
}
