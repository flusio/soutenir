<?php

namespace Website\models;

use Minz\Database;
use Minz\Validable;
use Website\utils;

/**
 * A PotUsage represents a payment by a customer made via the common
 * pot. It’s different from a Payment because it has no invoice attached and
 * doesn’t involve a payment via Stripe.
 *
 * As opposed to Payment, a PotUsage is always completed because it
 * doesn't involve the Stripe service. If the common pot is full enough, the
 * PotUsage is created. If it’s not, the payment is not created and is
 * refused to the user.
 *
 * @author Marien Fressinaud <dev@marienfressinaud.fr>
 * @license http://www.gnu.org/licenses/agpl-3.0.en.html AGPL
 */
#[Database\Table(name: 'pot_usages')]
class PotUsage
{
    use Database\Recordable;
    use Validable;

    #[Database\Column]
    public string $id;

    #[Database\Column]
    public \DateTimeImmutable $created_at;

    #[Database\Column]
    public ?\DateTimeImmutable $completed_at = null;
    #
    #[Database\Column]
    public bool $is_paid = false;

    #[Validable\Comparison(
        greater_or_equal: Payment::MIN_AMOUNT,
        less_or_equal: Payment::MAX_AMOUNT,
        message: 'Le montant doit être compris entre 1 et 120 €.',
    )]
    #[Database\Column]
    public int $amount;

    #[Validable\Inclusion(in: ['month', 'year'], message: 'Vous devez choisir l’une des deux périodes proposées.')]
    #[Database\Column]
    public string $frequency;

    #[Database\Column]
    public string $account_id;

    /**
     * Return the amount actually available in the common pot
     */
    public static function findAvailableAmount(): int
    {
        $sql = <<<'SQL'
            SELECT COALESCE(SUM(p.amount), 0) - (
                SELECT COALESCE(SUM(pu.amount), 0)
                FROM pot_usages pu
                WHERE pu.completed_at IS NOT NULL
            )
            FROM payments p
            WHERE p.type = "common_pot"
            AND p.completed_at IS NOT NULL
            AND p.id NOT IN (
                SELECT p2.credited_payment_id FROM payments p2
                WHERE p2.credited_payment_id NOT NULL
                AND p2.completed_at IS NOT NULL
            )
        SQL;

        $database = \Minz\Database::get();
        $statement = $database->query($sql);
        return intval($statement->fetchColumn());
    }

    /**
     * Change account_id of the given pot_usages
     *
     * @param string[] $pot_usages_ids
     */
    public static function moveToAccountId(array $pot_usages_ids, string $account_id): bool
    {
        $question_marks = array_fill(0, count($pot_usages_ids), '?');
        $in_statement = implode(',', $question_marks);
        $sql = <<<SQL
            UPDATE pot_usages
            SET account_id = ?
            WHERE id IN ({$in_statement})
        SQL;

        $database = \Minz\Database::get();
        $statement = $database->prepare($sql);
        $parameters = [$account_id];
        $parameters = array_merge($parameters, $pot_usages_ids);
        return $statement->execute($parameters);
    }
}
