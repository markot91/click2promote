using System;
using Newtonsoft.Json;
using System.IO;

namespace Click2PromoteMe.Helpers
{
    public class JSONNETSerializationHelper
    {
        public static void Serialize(Stream streamObject, object obj)
        {
            if (obj == null || streamObject == null)
                return;

            JsonSerializer ser = new JsonSerializer();
            JsonWriter jw = new JsonTextWriter(new StreamWriter(streamObject));
            ser.Serialize(jw, obj);
            jw.Flush();
        }

        public static object Deserialize(Stream streamObject, Type objectType)
        {
            if (objectType == null || streamObject == null)
                return null;

            JsonSerializer ser = new JsonSerializer();
            JsonReader jr = new JsonTextReader(new StreamReader(streamObject));
            return ser.Deserialize(jr, objectType);
        }
    }
}
