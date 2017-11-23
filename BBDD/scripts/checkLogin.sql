CREATE OR REPLACE FUNCTION
checkLogin(usr character varying(50), pss character varying (50))
RETURNS boolean AS $$
DECLARE
BEGIN
  return (Select count(password) from customers
  where username = 'latino' and password = 'neva'
  limit 1) = 1;
END;
$$ LANGUAGE plpgsql;

select checkLogin('latino','neva')







SELECT username, password from customers limit 1

Select count(password) from customers
where username = 'latino' and password = 'neva'
limit 1
