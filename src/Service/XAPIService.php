<?php
namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\Exception\ResponseException;
use QiQiuYun\SDK\Exception\SDKException;

class XAPIService extends BaseService
{
    protected $baseUri = 'http://xapi.qiqiuyun.net';

    protected $defaultLang = 'zh-CN';

    /**
     * 提交"听音频"的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function listenAudio($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://activitystrea.ms/schema/1.0/listen',
            'display' => array(
                'zh-CN' => '听了',
                'en-US' => 'listened'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'http://activitystrea.ms/schema/1.0/audio',
                'name' => array(
                    $this->defaultLang => $object['name'],
                ),
                'extensions' => array (
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => empty($object['resource']['globalId']) ? 0 : $object['resource']['globalId'],
                        'name' => empty($object['resource']['filename']) ? '' : $object['resource']['filename']
                    )
                )
            )
        );

        $statement['result'] = array(
            'duration' => $this->convertTime($result['duration']),
        );
        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“观看视频”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function watchVideo($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'https://w3id.org/xapi/acrossx/verbs/watched',
            'display' => array(
                'zh-CN' => '观看了',
                'en-US' => 'watched'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'https://w3id.org/xapi/acrossx/activities/video',
                'name' => array(
                    $this->defaultLang => $object['name'],
                ),
                'extensions' => array (
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => empty($object['resource']['globalId']) ? 0 : $object['resource']['globalId'],
                        'name' => empty($object['resource']['filename']) ? '' : $object['resource']['filename']
                    )
                )
            )
        );

        $statement['result'] = array(
            'duration' => $this->convertTime($result['duration']),
        );
        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“完成任务”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function finishActivity($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了',
                'en-US' => 'completed'
            )
        );

        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => $this->getActivityType($object['definitionType']),
                'name' => array(
                    $this->defaultLang => $object['name']
                ),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => empty($object['resource']['globalId']) ? 0 : $object['resource']['globalId'],
                        'name' => empty($object['resource']['filename']) ? '' : $object['resource']['filename']
                    )
                )
            )
        );

        $statement['result'] = array(
            'success' => true
        );

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“完成任务的弹题”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function finishActivityQuestion($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/answered',
            'display' => array(
                'zh-CN' => '回答了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'http://adlnet.gov/expapi/activities/interaction',
                'interactionType' => $object['type'],
                'description' => array(
                    $this->defaultLang => $object['stem'],
                ),
                'correctResponsesPattern' => $object['answer'],
                'choices' => $object['choices'],
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/activity' => array(
                        'id' => $object['activity']['id'],
                        'title' => $object['activity']['title']
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => empty($object['resource']['globalId']) ? 0 : $object['resource']['globalId'],
                        'name' => empty($object['resource']['filename']) ? '' : $object['resource']['filename']
                    )
                )
            )
        );

        $statement['result'] = array(
            'success' => $result['success'],
            'response' => $result['response'],
            'duration' => empty($result['duration']) ? '' : $this->convertTime($result['duration'])
        );

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“完成作业”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function finishHomework($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'http://xapi.edusoho.com/activities/homework',
                'name' => array(
                    $this->defaultLang => $object['name']
                ),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                )
            ),
        );
        $statement['result'] = empty($result) ? (object)$result : $result;

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“完成练习”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function finishExercise($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'http://xapi.edusoho.com/activities/exercise',
                'name' => array(
                    $this->defaultLang => $object['name']
                ),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                )
            ),
        );
        $statement['result'] = empty($result) ? (object)$result : $result;

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“完成考试”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function finishTestpaper($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'http://xapi.edusoho.com/activities/testpaper',
                'name' => array(
                    $this->defaultLang => $object['name']
                ),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                )
            ),
        );
        $statement['result'] = empty($result) ? (object)$result : $result;

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“记笔记”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function writeNote($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'https://w3id.org/xapi/adb/verbs/noted',
            'display' => array(
                'zh-CN' => '记录'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => $this->getActivityType($object['definitionType']),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => empty($object['resource']['globalId']) ? 0 : $object['resource']['globalId'],
                        'name' => empty($object['resource']['filename']) ? '' : $object['resource']['filename']
                    )
                )
            ),
        );
        $statement['result'] = array(
            'response' => $result['content']
        );

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }

    /**
     * 提交“提问题”的学习记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function askQuestion($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/asked',
            'display' => array(
                'zh-CN' => '提问了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => $this->getActivityType($object['definitionType']),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => empty($object['resource']['globalId']) ? 0 : $object['resource']['globalId'],
                        'name' => empty($object['resource']['filename']) ? '' : $object['resource']['filename']
                    )
                )
            )
        );
        $statement['result'] = array(
            'response' => $result['title'].'-'.htmlspecialchars_decode($result['content']),
        );

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;
    }


    /**
     * 提交"观看直播"的记录
     *
     * @param $actor
     * @param $object
     * @param $result
     * @param null $uuid
     * @param null $timestamp
     * @param bool $isPush
     * @return array
     * @throws ResponseException
     */
    public function watchLive($actor, $object, $result, $uuid = null, $timestamp = null, $isPush = true)
    {
        $statement = array();
        if (!empty($uuid)) {
            $statement['id'] = $uuid;
        }
        $statement['actor'] = $actor;
        $statement['verb'] = array(
            'id' => 'https://w3id.org/xapi/acrossx/verbs/watched',
            'display' => array(
                'zh-CN' => '观看了',
                'en-US' => 'watched'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'definition' => array(
                'type' => 'http://xapi.edusoho.com/activities/live',
                'name' => array(
                    $this->defaultLang => $object['name'],
                ),
                'extensions' => array (
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => empty($object['course']['id']) ? 0 : $object['course']['id'],
                        'title' => empty($object['course']['title']) ? '' : $object['course']['title'],
                        'description' => empty($object['course']['description']) ? '' : $object['course']['description'],
                    )
                )
            )
        );

        $statement['result'] = array(
            'duration' => $this->convertTime($result['duration']),
        );

        $statement['timestamp'] = $this->getTime($timestamp);

        return $isPush ? $this->pushStatement($statement) : $statement;

    }

    /**
     * 提交学习记录
     *
     * @param $statement
     * @return mixed
     * @throws ResponseException
     * @throws \QiQiuYun\SDK\HttpClient\ClientException
     */
    public function pushStatement($statement)
    {
        $statement['context'] = array(
            'extensions' => array (
                'http://xapi.edusoho.com/extensions/school' => $this->options['school'],
            )
        );

        $rawResponse = $this->client->request('POST', '/statements', array(
            'json' => array($statement),
            'headers' => array(
                'Authorization' => 'Signature '.$this->makeSignature(),
            )
        ));

        $response = json_decode($rawResponse->getBody(), true);

        if (isset($response['error'])) {
            throw new ResponseException($rawResponse);
        }

        return $statement;
    }

    /**
     * 批量提交学习记录
     * @param $statements
     * @return mixed
     * @throws ResponseException
     * @throws \QiQiuYun\SDK\HttpClient\ClientException
     */
    public function pushStatements($statements)
    {
        foreach ($statements as &$statement) {
            $statement['context'] = array(
                'extensions' => array (
                    'http://xapi.edusoho.com/extensions/school' => $this->options['school'],
                )
            );
        }

        $rawResponse = $this->client->request('POST', '/statements', array(
            'json' => $statements,
            'headers' => array(
                'Authorization' => 'Signature '.$this->makeSignature(),
            )
        ));

        $response = json_decode($rawResponse->getBody(), true);

        if (isset($response['error'])) {
            throw new ResponseException($rawResponse);
        }

        return $response;
    }

    /**
     * @param $verb
     * @return string
     * @throws SDKException
     */
    private function getVerbType($verb)
    {
        switch ($verb) {
            case 'answered': //回答了
                $verbType = 'http://adlnet.gov/expapi/verbs/answered';
                break;
            case 'asked': //提问了
                $verbType = 'http://adlnet.gov/expapi/verbs/asked';
                break;
            case 'completed': //完成了
                $verbType = 'http://adlnet.gov/expapi/verbs/completed';
                break;
            case 'liked': //喜欢
                $verbType = 'https://w3id.org/xapi/acrossx/verbs/liked';
                break;
            case 'listened': //听了
                $verbType = 'http://activitystrea.ms/schema/1.0/listen';
                break;
            case 'noted': //记录了
                $verbType = 'https://w3id.org/xapi/adb/verbs/noted';
                break;
            case 'read': //读了
                $verbType = 'https://w3id.org/xapi/adb/verbs/read';
                break;
            case 'watched': //观看了
                $verbType = 'https://w3id.org/xapi/acrossx/verbs/watched';
                break;
            default:
                throw new SDKException('Please input correct verb');
        }
        return $verbType;
    }

    /**
     * @param $minType
     * @return string
     */
    private function getActivityType($minType)
    {
        switch ($minType) {
            case 'audio': //音频
                $activityType = 'http://activitystrea.ms/schema/1.0/audio';
                break;
            case 'course': //课程
                $activityType = 'http://adlnet.gov/expapi/activities/course';
                break;
            case 'online-discussion':
                $activityType = 'https://w3id.org/xapi/acrossx/activities/online-discussion';
                break;
            case 'document': //文档,一个主要内容为文本的独立文件,包含word,excel,ppt,text等格式
                $activityType = 'https://w3id.org/xapi/acrossx/activities/document';
                break;
            case 'exercise': //练习,非xAPI标准
                $activityType = 'http://xapi.edusoho.com/activities/exercise';
                break;
            case 'homework': //作业,非xAPI标准
                $activityType = 'http://xapi.edusoho.com/activities/homework';
                break;
            case 'interaction': //互动
                $activityType = 'http://adlnet.gov/expapi/activities/interaction';
                break;
            case 'live': //直播,非xAPI标准
                $activityType = 'http://xapi.edusoho.com/activities/live';
                break;
            case 'question': //问题
                $activityType = 'http://adlnet.gov/expapi/activities/question';
                break;
            case 'testpaper': //试卷,非xAPI标准
                $activityType = 'http://xapi.edusoho.com/activities/testpaper';
                break;
            case 'video': //视频
                $activityType = 'https://w3id.org/xapi/acrossx/activities/video';
                break;
            default:
                $activityType = $minType;
        }

        return $activityType;

    }

    /**
     * @param $type
     * @return string
     * @throws SDKException
     */
    private function getExtensionId($type)
    {
        switch ($type) {
            case 'activity': //活动,非xAPI标准
                $id = 'http://xapi.edusoho.com/extensions/activity';
                break;
            case 'course': //活动所属课程,非xAPI标准
                $id = 'http://xapi.edusoho.com/extensions/course';
                break;
            case 'duration': //遵守ISO8601标准的时间长度
                $id = 'http://id.tincanapi.com/extension/duration';
                break;
            case 'ending-point': //活动发生的终点,遵守ISO8601标准
                $id = 'http://id.tincanapi.com/extension/ending-point';
                break;
            case 'resource': //活动对应的资源,非xAPI标准
                $id = 'http://xapi.edusoho.com/extensions/resource';
                break;
            case 'school': //活动所在的网校,非xAPI标准
                $id = 'http://xapi.edusoho.com/extensions/school';
                break;
            case 'starting-point': //活动发生的起点,遵守ISO8601标准
                $id = 'http://id.tincanapi.com/extension/starting-point';
                break;
            default:
                throw new SDKException('Please input correct type');
        }

        return $id;
    }

    protected function makeSignature()
    {
        $deadline = strtotime(date('Y-m-d H:0:0', strtotime('+2 hours')));
        $signingText = $this->auth->getAccessKey()."\n".$deadline;
        $signingText = $this->auth->getAccessKey().':'.$deadline.':'.$this->auth->sign($signingText);
        return $signingText;
    }

    protected function getTime($timestamp, $format = 'iso8601')
    {
        switch ($format) {
            case 'iso8601':
                $result = $this->getIsoTime($timestamp);
                break;
            default:
                $result = $timestamp;
        }

        return $result;
    }

    protected function convertTime($time, $format = 'iso8601')
    {
        switch ($format) {
            case 'iso8601':
                $result = $this->timeToIsoDuration($time);
                break;
            default:
                $result = $time;
        }

        return $result;
    }

    protected function timeToIsoDuration($time)
    {
        $units = array(
            "Y" => 365*24*3600,
            "D" => 24*3600,
            "H" => 3600,
            "M" => 60,
            "S" => 1,
        );

        $str = "P";
        $isTime = false;

        foreach ($units as $unitName => &$unit) {
            $quot  = intval($time / $unit);
            $time -= $quot * $unit;
            $unit  = $quot;
            if ($unit > 0) {
                if (!$isTime && in_array($unitName, array("H", "M", "S"))) {
                    $str .= "T";
                    $isTime = true;
                }
                $str .= strval($unit) . $unitName;
            }
        }

        return $str;
    }

    protected function getIsoTime($timestamp = null)
    {
        return empty($timestamp) ? date('c') : date('c', $timestamp);
    }

}
