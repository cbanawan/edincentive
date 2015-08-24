<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tables\User;

/**
 * UserSearch represents the model behind the search form about `common\models\tables\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'userTypeId'], 'integer'],
            [['dateCreated', 'dateLastModified', 'userName', 'userEmail', 'userPassword'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'userId' => $this->userId,
            'dateCreated' => $this->dateCreated,
            'dateLastModified' => $this->dateLastModified,
            'userTypeId' => $this->userTypeId,
        ]);

        $query->andFilterWhere(['like', 'userName', $this->userName])
            ->andFilterWhere(['like', 'userEmail', $this->userEmail])
            ->andFilterWhere(['like', 'userPassword', $this->userPassword]);

        return $dataProvider;
    }
}
