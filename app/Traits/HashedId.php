<?php

declare(strict_types=1);

namespace App\Traits;

use Hashids\Hashids;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HashedId
{
    use APIResponse;
    protected function getHashIdInstance(): Hashids
    {
        $salt = config('hashed_id.salt');
        $length = config('hashed_id.length');
        $alphabet = config('hashed_id.alphabet');

        return new Hashids($salt, $length, $alphabet);
    }

    protected static function bootHashedId(): void
    {
        static::retrieved(function ($model): void {
            if (!in_array('hashed_id', $model->appends ?? [], true)) {
                $model->appends[] = 'hashed_id';
            }
        });

        // // 👇 Automatically generate and save hashed_id after creating
        // static::created(function ($model) {
        //     if (empty($model->hashed_id)) {
        //         $model->hashed_id = $model->getHashIdInstance()->encode($model->getKey());
        //         // Avoid triggering an infinite loop
        //         $model->saveQuietly();
        //     }
        // });
    }

    public function getHashedIdAttribute()
    {
        return $this->getHashIdInstance()->encode($this->getKey());
    }

    public function getRouteKey()
    {
        return $this->hashed_id;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $decoded = $this->getHashIdInstance()->decode($value);

            if (empty($decoded) || empty($decoded[0])) {
                throw new NotFoundHttpException(__('validation.'));
            }

            return $this->find($decoded[0]) ?? throw new NotFoundHttpException(__('messages.data_not_found'));

        } catch (Exception $exception) {
            throw new NotFoundHttpException(__('messages.data_not_found'));
        }
    }

    public function decodeHashedId(string $hashedId): ?int
    {
        $instance = (new static())->getHashIdInstance();
        $decoded = $instance->decode($hashedId);
        return $decoded[0] ?? null;
    }
}
