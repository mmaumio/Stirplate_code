<?php

class UserController extends Controller
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionProfile()
    {

        if (!Yii::app()->user->isGuest) {

            $user = User::model()->findByPk(Yii::app()->user->id);

            if ($user) {
                $this->render('profile', array('user' => $user, 'readonly' => false));
                return;
            }
        }

        $this->redirect('/');
    }

    public function actionPublicProfile()
    {

        if (!Yii::app()->user->isGuest && !empty($_GET['id'])) {

            $user = User::model()->findByPk($_GET['id']);

            if ($user) {
                $this->render('profile', array('user' => $user, 'readonly' => true));
                return;
            }
        }

        //todo: render user not found
        $this->render('notfound');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        if (!Yii::app()->user->isGuest) {
            /* @var $model User */
            $model = new User;

            // Loads user model if signed in.
            if (isset(Yii::app()->session['uid'])) {
                $model = User::model()->findByPk(Yii::app()->session['uid']);
            }

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if (isset($_POST['User'])) {
                // Set attributes from 'POST'
                $model->attributes = $_POST['User'];

                // Saves model and then labs and techniques are saved.
                if ($model->save()) {
                    // Delete old labs and save new ones
                    if (!empty($model->selectedLabs)) {
                        $labs = LabUser::model()->findAllByAttributes(array('userId' => Yii::app()->session['uid']));
                        foreach ($labs as $lab) {
                            $lab->delete();
                        }
                        foreach ($model->selectedLabs as $lab) {
                            $labUser = new LabUser();
                            $labUser->userId = Yii::app()->session['uid'];
                            $labUser->labId = $lab;
                            $labUser->save();
                        }
                    }

                    // Delete old other lab name and save the new one
                    if (!empty($model->otherLabName)) {
                        /* @var $otherLabs LabUserOther */
                        $otherLabs = LabUserOther::model()->findAllByAttributes(array('userId' => Yii::app()->session['uid']));
                        if (!empty($otherLabs)) foreach ($otherLabs as $otherLab) $otherLab->delete();
                        $otherLab = new LabUserOther();
                        $otherLab->userId = Yii::app()->session['uid'];
                        $otherLab->name = $model->otherLabName;
                        $otherLab->save();
                    }

                    // Delete older techniques and save new ones
                    if (!empty($model->selectedTechs)) {
                        $techs = TechUser::model()->findAllByAttributes(array('userId' => Yii::app()->session['uid']));
                        foreach ($techs as $tech) {
                            $tech->delete();
                        }
                        foreach ($model->selectedTechs as $tech) {
                            $techUser = new TechUser();
                            $techUser->userId = Yii::app()->session['uid'];
                            $techUser->techId = $tech;
                            $techUser->save();
                        }
                    }

                    // Delete old other technique and save new one
                    if (!empty($model->otherTechName)) {
                        /* @var $otherTechs TechUserOther */
                        $otherTechs = TechUserOther::model()->findAllByAttributes(array('userId' => Yii::app()->session['uid']));
                        if (!empty($otherTechs)) foreach ($otherTechs as $otherTech) $otherTech->delete();
                        $otherTech = new TechUserOther();
                        $otherTech->userId = Yii::app()->session['uid'];
                        $otherTech->name = $model->otherTechName;
                        $otherTech->save();
                    }

                    // Delete older user positions and save new ones
                    if (!empty($model->selectedPositions)) {
                        $positions = UserPosition::model()->findAllByAttributes(array('userId' => Yii::app()->session['uid']));
                        foreach ($positions as $position) {
                            $position->delete();
                        }
                        foreach ($model->selectedPositions as $position) {
                            $userPosition = new UserPosition();
                            $userPosition->userId = Yii::app()->session['uid'];
                            $userPosition->positionId = $position;
                            $userPosition->save();
                        }
                    }

//                $this->redirect(array('create', 'id' => $model->id));
                    // sets success flash named 'update'
                    Yii::app()->user->setFlash('update', Yii::app()->params['SUCCESS']);
                } else {
                    // sets failure flash named 'update'
                    Yii::app()->user->setFlash('update', Yii::app()->params['FAILURE']);
                }
            }
            $this->render('create', array(
                'model' => $model,
                'readonly' => false,
            ));
        } else {
            $this->redirect(array('site/index'));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        if (!Yii::app()->user->isGuest && $id === Yii::app()->user->id) {
            $model = $this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                Yii::log(json_encode($_POST['User']), 'error');

                if (!empty($_POST['currentPassword']) || empty($model->password)) {
                    if (User::hashPassword($_POST['currentPassword']) != $model->password && !empty($model->password)) {
                        $msg = 'Current Password is incorrect';
                        $this->render('profile', array('user' => $model, 'errorMsg' => $msg, 'readonly' => false));
                        return;
                    }

                    if ($_POST['newPassword'] != $_POST['repeatPassword']) {
                        $msg = 'New and Repeat passwords don\'t match';
                        $this->render('profile', array('user' => $model, 'errorMsg' => $msg, 'readonly' => false));
                        return;
                    }

                    $model->password = User::hashPassword($_POST['newPassword']);
                }
                if ($model->save()) {
                    $msg = 'Your updates have been saved successfully';

                    $this->render('profile', array('user' => $model, 'alertMsg' => $msg, 'readonly' => false));
                    return;
                }
            }
            $msg = 'Error saving profile';
            $this->render('profile', array('user' => $model, 'errorMsg' => $msg, 'readonly' => false));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
