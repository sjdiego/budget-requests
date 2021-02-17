<?php

namespace App;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;

/**
 * Class that manages Budget requests and all its resources
 *
 * @property string title
 * @property string description
 * @property integer category_id
 * @property integer status_id
 * @property integer user_id
 *
 * @package App
 */
class Budget extends Model
{
    const STATUS_PENDING   = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_DISCARDED = 3;

    public $statusLabels = [
        self::STATUS_PENDING   => 'Pendiente',
        self::STATUS_PUBLISHED => 'Publicada',
        self::STATUS_DISCARDED => 'Descartada',
    ];

    protected $fillable = [
        'title', 'description', 'category_id', 'status_id', 'user_id'
    ];

    /**
     * Relationship between Budget and its User
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship between Budget and its Category
     *
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * It returns the label for status_id field
     *
     * @return string
     */
    public function getStatusLabelAttribute() : string
    {
        return isset($this->status_id)
        && isset($this->statusLabels[$this->status_id])
            ? $this->statusLabels[$this->status_id]
            : '-';
    }

    /**
     * It updates some fields of the budget request
     *
     * @return bool
     * @throws HttpResponseException
     */
    public function edit()
    {
        if (!request()->hasAny(['title', 'description', 'category'])) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => 'Faltan parámetros'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        if ($this->status_id !== Budget::STATUS_PENDING) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => 'La solicitud debe estar Pendiente'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        if (request()->has('title')) {
            $this->title = request()->get('title');
        }

        if (request()->has('description')) {
            $this->description = request()->get('description');
        }

        if (request()->has('category')) {
            $this->category()->associate(request()->get('category'));
        }

        return $this->save();
    }

    /**
     * It changes the status of a budget request
     *
     * @return bool
     * @throws HttpResponseException
     */
    public function publish()
    {
        if ($this->status_id !== self::STATUS_PENDING) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => 'La solicitud debe estar Pendiente'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        if (!$this->has('category')) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => 'La solicitud debe tener asociada una categoría'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        if (!$this->title || !strlen($this->title)) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => 'La solicitud debe tener un título'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        $this->status_id = self::STATUS_PUBLISHED;

        return $this->save();
    }

    /**
     * It discards a budget request
     *
     * @return bool
     * @throws HttpResponseException
     */
    public function discard()
    {
        if ($this->status_id === self::STATUS_DISCARDED) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => 'La solicitud ya está descartada'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        $this->status_id = self::STATUS_DISCARDED;

        return $this->save();
    }
}
