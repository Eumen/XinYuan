--
-- Set default database
--
USE xinyuan;

--
-- Drop procedure `calFutou`
--
DROP PROCEDURE IF EXISTS calFutou;

--
-- Drop procedure `genJdParents`
--
DROP PROCEDURE IF EXISTS genJdParents;

--
-- Drop procedure `getParentAgent`
--
DROP PROCEDURE IF EXISTS getParentAgent;

--
-- Set default database
--
USE xinyuan;

DELIMITER $$

--
-- Create procedure `getParentAgent`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE getParentAgent (IN rootId int, OUT agentId varchar(50))
BEGIN
  DECLARE tempId int(5);
  DECLARE fatherId int(5);
  DECLARE treeLevel int(5);
  DECLARE id int(5);
  DECLARE tmpAgent varchar(2);

  SET treeLevel = 0;
  SET tempId = rootId;

outer_label:
  BEGIN
    WHILE tempId <> 1
      AND treeLevel < 11 DO
      SELECT
        m.father_id INTO fatherId
      FROM xy_member m
      WHERE m.id = tempId;
      SELECT
        xm.id,
        xm.is_agent INTO id, tmpAgent
      FROM xy_member xm
      WHERE xm.id = fatherId;
      IF tmpAgent = 1 THEN
        SET agentId = id;
        LEAVE outer_label;
      END IF;

      SET treeLevel = treeLevel + 1;
      SET tempId = fatherId;
    END WHILE;
  END outer_label;
END
$$

--
-- Create procedure `genJdParents`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE genJdParents (IN rootId int, IN sonId varchar(255), IN sonName varchar(255), OUT code varbinary(255))
BEGIN
  DECLARE tempId int(5);
  DECLARE fatherId int(5);
  DECLARE treeLevel int(5);

  DECLARE tmpUserId varchar(255);
  DECLARE tmpUserName varchar(255);

  SET treeLevel = 0;
  SET tempId = rootId;

  WHILE tempId <> 1
    AND treeLevel < 11 DO
    SELECT
      m.father_id INTO fatherId
    FROM xy_member m
    WHERE m.id = tempId;
    SELECT
      user_id,
      user_name INTO tmpUserId, tmpUserName
    FROM xy_member xm
    WHERE xm.id = fatherId;
    INSERT INTO xy_personbonusdetail (user_id, user_name, money, son_id, son_name, bonus_type, bz, time)
      VALUES (tmpUserId, tmpUserName, 90, sonId, sonName, 6, 'FtJd', NOW());
    SET treeLevel = treeLevel + 1;
    SET tempId = fatherId;
  END WHILE;

  SET CODE = 1;
END
$$

--
-- Create procedure `calFutou`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE calFutou (OUT code int, OUT msg varchar(255))
BEGIN
  -- 定义变量
  DECLARE cur_user_Id varchar(50);
  DECLARE sum_money int(100);
  DECLARE done int DEFAULT 0;

  DECLARE tmp_re_money int(10);
  -- 变量推荐人
  DECLARE TMP_RE_USER_ID varchar(50);
  DECLARE tmp_RE_user_name varchar(50);
  -- 变量当前人
  DECLARE TMP_CURRENT_ID varchar(50);
  DECLARE TMP_CURRENT_USER_ID varchar(50);
  DECLARE tmp_CURRENT_user_name varchar(50);

  DECLARE TMP_BD_USER_ID varchar(50);
  DECLARE tmp_BD_user_name varchar(50);

  DECLARE parents varchar(50);

  DECLARE agentId varchar(50);

  -- 查询奖金
  DECLARE cur_user_sum_money CURSOR FOR
  (SELECT
      user_id,
      SUM(money)
    FROM xy_personbonusdetail
    GROUP BY user_id);
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = NULL;

outer_label:
  BEGIN

    OPEN cur_user_sum_money;
    FETCH cur_user_sum_money INTO cur_user_Id, sum_money;
    WHILE (done IS NOT NULL) DO
      SELECT
        re_money INTO tmp_re_money
      FROM xy_member m
      WHERE m.user_id = cur_user_Id;
      IF (sum_money / 10 - tmp_re_money) = 3000 THEN
        -- 更新复投金额
        UPDATE xy_member m
        SET m.re_money = (m.re_money + 3000)
        WHERE m.user_id = cur_user_Id;
        -- 生成推荐奖
        SELECT
          m.re_id,
          m.re_name INTO TMP_RE_USER_ID, tmp_RE_user_name
        FROM xy_member m
        WHERE m.user_id = cur_user_Id;
        SELECT
          m.id,
          m.user_id,
          m.user_name INTO TMP_CURRENT_ID, TMP_CURRENT_USER_ID, tmp_CURRENT_user_name
        FROM xy_member m
        WHERE m.user_id = cur_user_Id;
        INSERT INTO xy_personbonusdetail (user_id, user_name, money, son_id, son_name, bonus_type, bz, time)
          VALUES (TMP_RE_USER_ID, tmp_RE_user_name, 300, TMP_CURRENT_USER_ID, tmp_CURRENT_user_name, 4, 'ftTj', NOW());

        -- 生成见点奖
        CALL genJdParents(TMP_CURRENT_ID, TMP_CURRENT_USER_ID, tmp_CURRENT_user_name, code);

        IF code <> 1 THEN
          SET CODE = 0;
          SET msg = 'JianDian Exception';
          LEAVE outer_label;
        END IF;

        -- 生成报单奖
        CALL getParentAgent(TMP_CURRENT_ID, agentId);
        SELECT
          m.user_id,
          m.user_name INTO TMP_BD_USER_ID, tmp_BD_user_name
        FROM xy_member m
        WHERE m.id = agentId;
        INSERT INTO xy_personbonusdetail (user_id, user_name, money, son_id, son_name, bonus_type, bz, time)
          VALUES (TMP_BD_USER_ID, tmp_BD_user_name, 200, TMP_CURRENT_USER_ID, tmp_CURRENT_user_name, 5, 'ftBd', NOW());

      END IF;
      /*游标向下走一步*/
      FETCH cur_user_sum_money INTO cur_user_Id, sum_money;
    END WHILE;
    CLOSE cur_user_sum_money;
    SET CODE = 1;
  END outer_label;
END
$$

DELIMITER ;