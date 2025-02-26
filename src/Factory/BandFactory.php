<?php

namespace App\Factory;

use App\Entity\Band;
use App\Repository\BandRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Band>
 *
 * @method        Band|Proxy                     create(array|callable $attributes = [])
 * @method static Band|Proxy                     createOne(array $attributes = [])
 * @method static Band|Proxy                     find(object|array|mixed $criteria)
 * @method static Band|Proxy                     findOrCreate(array $attributes)
 * @method static Band|Proxy                     first(string $sortedField = 'id')
 * @method static Band|Proxy                     last(string $sortedField = 'id')
 * @method static Band|Proxy                     random(array $attributes = [])
 * @method static Band|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BandRepository|RepositoryProxy repository()
 * @method static Band[]|Proxy[]                 all()
 * @method static Band[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Band[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Band[]|Proxy[]                 findBy(array $attributes)
 * @method static Band[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Band[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class BandFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(30),
            'city' => self::faker()->text(30),
            'origin' => self::faker()->text(30),
            'startYear' => self::faker()->numberBetween(1950, 1990),
            'founders' => self::faker()->name(),
            'members' => self::faker()->numberBetween(1, 7),
            'musicalCurrent' => self::faker()->text(30),
            'presentation' => self::faker()->realTextBetween(100, 500),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(Band $band): void {})
    }

    protected static function getClass(): string
    {
        return Band::class;
    }
}
